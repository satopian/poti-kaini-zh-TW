<?php
//POTI-board plugin search(C)2020-2022 さとぴあ(@satopian)
//v5.0 lot.22015
//POTI-board EVO v5.0 対応版
//https://paintbbs.sakura.ne.jp/
//フリーウェアですが著作権は放棄しません。

//使用条件。

//著作表記のリンクを削除したり見えなくしないでください。

//免責

//このプログラムを利用した事によって発生したいかなる損害も作者は一切の責任を負いません。

//サポート

//ご質問は

//GitHubのこのプログラムのリポジトリのIssuesにお願いします。
//GitHubの開発配布のためのリポジトリ
//https://github.com/satopian/potiboard_plugin/

//設定
//何件までしらべるか？
//初期値120 あまり大きくしないでください。
$max_search=120;
//設定を変更すればより多く検索できるようになりますが、サーバの負荷が高くなります。

//更新履歴

//v5.0.0 2022.01.16 テンプレートエンジンをbladeに変更。
//v1.7.1 2021.08.25 ツリーの照合方式を変更。config.phpで設定したタイムゾーンが反映されるようにした。
//v1.7.0 2021.07.07 v3.03.1 対応。マークダウン記法による自動リンクの文字部分だけを表示。出力時のエスケープ処理追加。
//v1.6.9 2021.03.10 ２重エンコードにならないようにした。
//v1.6.8 2021.03.10 未定義エラーを修正。
//v1.6.6 2021.01.17 PHP8環境で致命的エラーが出るバグを修正。1発言分のログが4096バイト以上の時に処理できなくなるバグを修正。
//v1.6.5 2020.10.02 波ダッシュと全角チルダを区別しない。
//v1.6.3 2020.09.11 1ページ目の画像の表示枚数が19枚になっていたのを修正。
//v1.6.2 2020.08.26 画像検索でis_file()のチェックが２重になっていたのを修正。
//v1.6.1 2020.08.15 radioボタン未チェックの時の動作を修正。
//v1.6 2020.08.13 削除ずみのスレッドのレスが表示されるバグを修正。
//本文も全角英数、半角英数どちらでも検索できるようにした。
//v1.5 2020.07.19 改二以外のPOTI-boardでも使えるようにした。
//v1.4 2020.07.18 負荷削減。画像のis_fileの処理の見直し。
//v1.3 2020.07.18 イラストの単位を「枚」、コメントの単位を「件」に。
//v1.2 2020.07.14 last modifiedが表示されないバグを修正。
//v1.1 2020.07.14 HTMLとCSSをテーマディレクトリに分離。
//v0.5 2020.07.14 イラストの表示数を1ページあたり20枚、コメントの表示数を30件に。
//v0.4 2020.07.14 compact()で格納してextract()で展開するようにした。 
//v0.3 2020.07.14 コード整理と高速化。
//v0.2 2020.07.14 負荷削減。ページングで表示している記事の分だけレス先を探して見つけるようにした。
//v0.1 2020.07.13 GitHubに公開

//設定の読み込み
require(__DIR__.'/config.php');

defined('SKIN_DIR') or define('SKIN_DIR','basic/');//config.php で未定義なら basic/

//HTMLテンプレート
require_once __DIR__.'/BladeOne/lib/BladeOne.php';

Use eftec\bladeone\BladeOne;


$views = __DIR__ . '/templates/'.SKIN_DIR;
$cache = $views.'cache';
$blade = new BladeOne($views,$cache,BladeOne::MODE_AUTO);


$dat['skindir'] = 'templates/'.SKIN_DIR;
$dat['php_self2']=h(PHP_SELF2);

//タイムゾーン
defined('DEFAULT_TIMEZONE') or define('DEFAULT_TIMEZONE','Asia/Tokyo');
date_default_timezone_set(DEFAULT_TIMEZONE);

//マークダウン記法のリンクをHTMLに する:1 しない:0
defined('MD_LINK') or define('MD_LINK', '0');

//filter_input

$imgsearch=filter_input(INPUT_GET,'imgsearch',FILTER_VALIDATE_BOOLEAN) ? true : false;
$page=filter_input(INPUT_GET,'page',FILTER_VALIDATE_INT);
$page= $page ? $page : 1;
$query=filter_input(INPUT_GET,'query');
$query=urldecode($query);
$query=mb_convert_kana($query, 'rn', 'UTF-8');
$query=str_replace(array(" ", "　"), "", $query);
$query=str_replace("〜","～",$query);//波ダッシュを全角チルダに
$query=h($query);
$radio =filter_input(INPUT_GET,'radio',FILTER_VALIDATE_INT);

if($imgsearch){
	$disp_count_of_page=20;//画像検索の時の1ページあたりの表示件数
}
else{
	$disp_count_of_page=30;//通常検索の時の1ページあたりの表示件数
}

//ログの読み込み
$i=0;$j=0;
$arr=[];
$tree=file(TREEFILE);
$oya = [];
foreach ($tree as $line) {
	$tree_nos = explode(',', trim($line));
	foreach ($tree_nos as $tree_no) {
		$oya[$tree_no] = $tree_nos[0]; //キーにres no、値にoya no
	}
}

$fp = fopen(LOGFILE, "r");
while ($line = fgets($fp)) {
	list($no,,$name,,$sub,$com,,,,$ext,,,$time,,,) = explode(",", $line);
	if(!isset($oya[$no])){
		continue;
	}

	$continue_to_search=true;
	if($imgsearch){//画像検索の場合
		$continue_to_search=($ext&&is_file(IMG_DIR.$time.$ext));//画像があったら
	}

	if($continue_to_search){
		if($radio===1||$radio===2||$radio===null){
			$s_name=mb_convert_kana($name, 'rn', 'UTF-8');//全角英数を半角に
			$s_name=str_replace(array(" ", "　"), "", $s_name);
			$s_name=str_replace("〜","～", $s_name);//波ダッシュを全角チルダに
		}
		else{
			$s_sub=mb_convert_kana($sub, 'rn', 'UTF-8');//全角英数を半角に
			$s_sub=str_replace(array(" ", "　"), "", $s_sub);
			$s_sub=str_replace("〜","～", $s_sub);//波ダッシュを全角チルダに
			$s_com=mb_convert_kana($com, 'rn', 'UTF-8');//全角英数を半角に
			$s_com=str_replace(array(" ", "　"), "", $s_com);
			$s_com=str_replace("〜","～", $s_com);//波ダッシュを全角チルダに
		}
		
		//ログとクエリを照合
		if($query===''||//空白なら
				$query!==''&&$radio===3&&stripos($s_com,$query)!==false||//本文を検索
				$query!==''&&$radio===3&&stripos($s_sub,$query)!==false||//題名を検索
				$query!==''&&($radio===1||$radio===null)&&stripos($s_name,$query)!==false||//作者名が含まれる
				$query!==''&&($radio===2&&$s_name===$query)//作者名完全一致
		){
			$link='';
			$link=PHP_SELF.'?res='.$oya[$no];
			$arr[]=compact('no','name','sub','com','ext','time','link');
			++$i;
		}
			if($i>=$max_search){break;}//1掲示板あたりの最大検索数
		
	}

	if($j>=5000){break;}//1掲示板あたりの最大行数
	++$j;

}
	fclose($fp);

//検索結果の出力
$j=0;
$dat['comments']=[];
if($arr){
	foreach($arr as $i => $val){
		if($i > $page-2){//$iが表示するページになるまで待つ
			extract($val);
			$img='';
			if($ext){
				if(is_file(THUMB_DIR.$time.'s.jpg')){//サムネイルはあるか？
					$img=THUMB_DIR.$time.'s.jpg';
				}
				elseif($imgsearch||is_file(IMG_DIR.$time.$ext)){
					$img=IMG_DIR.$time.$ext;
					}
				}

			$time=(int)substr($time,-13,10);
			$postedtime =$time ? (date("Y/m/d G:i", $time)) : '';
			$sub=h(strip_tags($sub));
			$com=str_replace('<br />',' ',$com);
			if(MD_LINK){
				$com= preg_replace("{\[([^\[\]\(\)]+?)\]\((https?://[[:alnum:]\+\$\;\?\.%,!#~*/:@&=_-]+)\)}","\\1",$com);
			}
			$com=h(strip_tags($com));
			$com=mb_strcut($com,0,180);
			$name=h(strip_tags($name));
			$encoded_name=urlencode($name);
			//変数格納
			$dat['comments'][]= compact('no','name','encoded_name','sub','img','com','link','postedtime');

		}
			$j=$i+1;//表示件数
			if($i >= $page+$disp_count_of_page-2){break;}
	}
}
unset($sub,$name,$no,$boardname);
unset($i,$val);

$search_type='';
if($imgsearch){
	$search_type='&imgsearch=on';
	$img_or_com='イラスト';
	$mai_or_ken='枚';
}
else{
	$img_or_com='コメント';
	$mai_or_ken='件';
}
$dat['imgsearch']= $imgsearch ? true : false;

//クエリを検索窓に入ったままにする
$dat['query']=h($query);
//ラジオボタンのチェック
$dat['radio_chk1']='';//作者名
$dat['radio_chk2']='';//完全一致
$dat['radio_chk3']='';//本文題名	
$query_l='&query='.urlencode(h($query));//クエリを次ページにgetで渡す
if($query!==''&&$radio===3){//本文題名
	$query_l.='&radio=3';
	$dat['radio_chk3']='checked="checked"';
}
elseif($query!==''&&$radio===2){//完全一致
	$query_l.='&radio=2';
	$dat['radio_chk2']='checked="checked"';	
}
elseif($query!==''&&($radio===null||$radio===1)){//作者名
	$query_l.='&radio=1';
	$dat['radio_chk1']='checked="checked"';
}
else{//作者名	
	$query_l='';
	$dat['radio_chk1']='checked="checked"';
}
$dat['query_l']=$query_l;

$dat['page']=(int)$page;

$dat['img_or_com']=$img_or_com;
$dat['pageno']='';
if($j&&$page>=2){
	$dat['pageno'] = $page.'-'.$j.$mai_or_ken;
}
elseif($j){
		$dat['pageno'] = $j.$mai_or_ken;
}
if($query!==''&&$radio===3){
	$dat['title']=$query.'の'.$img_or_com;//titleタグに入る
	$dat['h1']=$query.'の';//h1タグに入る
}
elseif($query!==''){
	$dat['title']=$query.'さんの'.$img_or_com;
	$dat['h1']=$query.	'さんの';
}
else{
	$dat['title']='掲示板に投稿された最新の'.$img_or_com;
	$dat['h1']='掲示板に投稿された最新の';
}

//ページング

$nxetpage=$page+$disp_count_of_page;//次ページ
$prevpage=$page-$disp_count_of_page;//前のページ
$countarr=count($arr);//配列の数
$dat['prev']=false;
$dat['nxet']=false;

if($page<=$disp_count_of_page){
	$dat['prev']='<a href="./'.h(PHP_SELF2).'">掲示板にもどる</a>';//前のページ
if($countarr>=$nxetpage){
	$dat['nxet']='<a href="?page='.$nxetpage.$search_type.$query_l.'">次の'.$disp_count_of_page.$mai_or_ken.'≫</a>';//次のページ
}
}

elseif($page>=$disp_count_of_page+1){
	$dat['prev']= '<a href="?page='.$prevpage.$search_type.$query_l.'">≪前の'.$disp_count_of_page.$mai_or_ken.'</a>'; 
	if($countarr>=$nxetpage){
		$dat['nxet']='<a href="?page='.$nxetpage.$search_type.$query_l.'">次の'.$disp_count_of_page.$mai_or_ken.'≫</a>';
	}
	else{
		$dat['nxet']='<a href="./'.h(PHP_SELF2).'">掲示板にもどる</a>';
	}
}
//最終更新日時を取得
$postedtime= $arr ? $arr[0]['time']:'';
$postedtime=(int)substr($postedtime,-13,10);
$dat['lastmodified']=$arr ? ($postedtime ? (date("Y/m/d G:i", $postedtime)) : '') :'';

unset($arr);

function h($str){
	return htmlspecialchars($str,ENT_QUOTES,'utf-8',false);
}
//HTML出力
echo $blade->run('search',$dat);


