{{-- ********** お絵かきテンプレート **********
// このテンプレートは、以下のモード用テンプレートです
// ・お絵かきモード
// ・動画表示モード
// ・コンティニューモード
 --}}
<!DOCTYPE html>

<html lang="zh-Hant-TW">
<head>
<meta charset="utf-8">
@if($paint_mode)
<meta name="robots" content="noindex,follow">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
@endif
@if($pch_mode)<meta name="viewport" content="width=device-width,initial-scale=1.0">@endif
@if($continue_mode)
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
<link rel="preload" as="script" href="lib/{{$jquery}}">
<link rel="preload" as="script" href="{{$skindir}}js/basic_common.js?{{$ver}}">
@endif
<link rel="stylesheet" type="text/css" href="{{$skindir}}basic.css?{{$ver}}">
<title>@if($paint_mode)繪圖模式@endif @if($continue_mode)續繪@endif @if($pch_mode)過程顯示模式@endif - {{$title}}</title>
{{--  
// title…掲示板タイトル
// charset…文字コード
 --}}
@if($continue_mode)
 <style>
	 /* index.cssを更新しない人がいるかもしれないためインラインでも記述 */
	 #span_cont_paint_same_thread {
		 display: none;
	 }
</style>
@endif	
@if($paint_mode)
<style>
	body{overscroll-behavior-x: none !important; }
	div#chickenpaint-parent , div.appstage {
		letter-spacing: initial;
		word-break:initial;
		overflow-wrap: initial;
	}
	a{text-decoration-skip-ink: initial;}
</style>
@endif
@if($chickenpaint)
<style>
	li{margin:0 0 0 1em;}
	:not(input),div#chickenpaint-parent :not(input){
		-moz-user-select: none;
		-webkit-user-select: none;
		-ms-user-select: none;
		user-select: none;
	}
</style>
<script>
	document.addEventListener('DOMContentLoaded',function(){
		document.addEventListener('dblclick', function(e){ e.preventDefault()}, { passive: false });
		const chicken=document.querySelector('#chickenpaint-parent');
		chicken.addEventListener('contextmenu', function(e){
			e.preventDefault();
			e.stopPropagation();
		}, { passive: false });
	});
</script>

<script src="chickenpaint/js/chickenpaint.min.js?{{$parameter_day}}&{{$ver}}"></script>

<link rel="stylesheet" href="chickenpaint/css/chickenpaint.css?{{$parameter_day}}&{{$ver}}">

@else
<!-- NEOを使う -->
<script>
	document.paintBBSCallback = function (str) {
		console.log('paintBBSCallback', str)
		if (str == 'check') {
			return true;
		} else {
			return;
		}
		}
	</script>
@if($useneo) 
<link rel="stylesheet" href="neo.css?{{$parameter_day}}&{{$ver}}">
<script src="neo.js?{{$parameter_day}}&{{$ver}}"></script>
<script>
	Neo.handleExit=()=>{
	@if($rep)
		// 画像差し換えに必要なフォームデータをセット
		const formData = new FormData();
		formData.append("mode", "picrep"); 
		formData.append("no", "{{$no}}"); 
		formData.append("pwd", "{{$pwd}}"); 
		formData.append("repcode", "{{$repcode}}");

		// 画像差し換え

	fetch("{{$sefl}}", {
		method: 'POST',
		mode: 'same-origin',
		headers: {
			'X-Requested-With': 'PaintBBS'
			,
		},
				body: formData
		})
		.then(response => {
// console.log("response",response);
			if (response.ok) {

				if (response.redirected) {
					return window.location.href = response.url;
				}
				response.text().then((text) => {
					//console.log(text);
					if (text.startsWith("error\n")) {
							console.log(text);
							return window.location.href = "?mode=piccom&stime={{$stime}}";
					}
				})
			}
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
		return window.location.href = "?mode=piccom&stime={{$stime}}";
    });
	@else
	return window.location.href = "?mode=piccom&stime={{$stime}}";
	@endif
	}
</script>
@endif
@if($paint_mode) 
	@if(!$chickenpaint)
	<script>
		//Firefoxのメニューバーが開閉するのため、Altキーのデフォルトの処理をキャンセル
		document.addEventListener('keyup', function(e) {//しぃペインター NEO共通
			// e.key を利用して特定のキーのアップイベントを検知する
			if (e.key.toLowerCase() === 'alt') {
				e.preventDefault(); // Alt キーのデフォルトの動作をキャンセル
			}
		});
	</script>
	@endif
@endif
@if($pch_mode and $type_neo) 
<link rel="stylesheet" href="neo.css?{{$parameter_day}}&{{$ver}}">
<script src="neo.js?{{$parameter_day}}&{{$ver}}"></script>
@endif
	@if(($paint_mode and !$useneo) or ($pch_mode and !$type_neo))
	<!-- Javaが使えるかどうか判定 -->
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			var jEnabled = navigator.javaEnabled();
			if(!jEnabled){
				var sN = document.createElement("script");
				sN.src = "{{$cheerpj_url}}";
				sN.integrity="{{$cheerpj_hash}}";
				sN.crossOrigin="anonymous";
				var s0 = document.getElementsByTagName("script")[0];
				s0.parentNode.insertBefore(sN, s0);
				sN.addEventListener("load", function(){ cheerpjInit({!!htmlspecialchars($cheerpj_preload,ENT_NOQUOTES)!!}); }, false);
			}
		});
	</script>
	@endif
@endif
<style id="for_mobile"></style>

</head>
<body>
<header>
@if($paint_mode) 
@if(!$chickenpaint)
<h1 style= "min-width:calc({{$w}}px + 176px)" id="bbs_title">繪圖模式 - <span class="title_name_wrap">{{$title}}</span></h1>
@endif

@else
<h1 id="bbs_title">@if($continue_mode) 續繪@endif @if($pch_mode) 過程顯示模式@endif - <span class="title_name_wrap">{{$title}}</span></h1>@endif
{{-- お絵かきモード --}}
{{-- 
// 【お絵かき(通常/続き)】
//
// paint_mode…お絵かきモードのとき true が入る
// home…ホームページURL
// self…POTI-boardのスクリプト名
// self2…入口(TOP)ページのURL
// palettes…パレット配列データ
// paintbbs…PaintBBSを選択したとき true が入る
// normal…しぃペインターを選択したとき true が入る
// pro…しぃペインターProを選択したとき true が入る
// w…アプレット領域サイズ(横)
// h…アプレット領域サイズ(縦)
// layer_count…レイヤー数(しぃペインター)
// quality…クオリティ値(しぃペインター)
// picw…キャンバスサイズ(横)
// pich…キャンバスサイズ(縦)
// image_jpeg…JPEG保存を許可してるなら true が入る(AUTO or JPEG)
// image_size…JPEG変換(AUTO)もしくは減色処理(PNG)の判定値(KB)
// compress_level…PNGの減色率とJPEGの圧縮率
// undo…アンドゥの回数
// undo_in_mg…アンドゥを幾つにまとめて保存しておくか
// mode…投稿モード指示
// stime…描画開始時間(UNIXタイムスタンプ)
// anime…動画記録ONなら true が入る
// pchfile…動画ファイル名(動画から続きを描く場合)
// imgfile…画像ファイル名(画像から続きを描く場合)
// usercode…ユーザーコード(投稿者認識用)
// palsize…パレット総数
// dynp…パレットの名前配列データ
// applet…しぃペインターを使用するとき true が入る
// usepbbs…しぃペインターとPaintBBSの両方を使用するとき true が入る
// palette…パレット選択用データ(selectタグ用option配列)
// newpaint…新規お絵かきのとき true が入る(コンティニューは false)
// savetypes…保存タイプ選択用データ(selectタグ用option配列)
// animeform…動画記録出来るときに true が入る(画像から続きを描く場合は false)
// qualitys…クオリティ値選択用データ(selectタグ用option配列)
// resno…レス時の親記事No
// no…記事No(コンティニュー)
// pch…動画ファイル名(コンティニュー)
// ctype…動画からの続きか、画像からの続きか(コンティニュー)
// type…差し換えか、新規投稿か(コンティニュー)
// pwd…記事Pass(コンティニュー)
// ext…画像拡張子(コンティニュー)
 --}}
@if($paint_mode) 
@if($chickenpaint)

<div id="chickenpaint-parent"></div>
<p></p>

<script>
	document.addEventListener("DOMContentLoaded", function() {
		new ChickenPaint({
			uiElem: document.getElementById("chickenpaint-parent"),
			canvasWidth: {{$picw}},
		canvasHeight: {{$pich}},

		@if($imgfile) loadImageUrl: "{{$imgfile}}",@endif
		@if($img_chi) loadChibiFileUrl: "{{$img_chi}}",@endif
		saveUrl: "?mode=saveimage&tool=chi&usercode={!!$usercode!!}",
		postUrl: "?mode={!!$mode!!}&stime={{$stime}}",
		exitUrl: "?mode={!!$mode!!}&stime={{$stime}}",

			allowDownload: true,
			resourcesRoot: "chickenpaint/",
			disableBootstrapAPI: true,
			fullScreenMode: "force",
			post_max_size: {{$max_pch}}
		});
	});

	const handleExit=()=>{
	@if($rep)
    // 画像差し換えに必要なフォームデータをセット
    const formData = new FormData();
    formData.append("mode", "picrep"); 
    formData.append("no", "{{$no}}"); 
    formData.append("pwd", "{{$pwd}}"); 
	formData.append("repcode", "{{$repcode}}");

    // 画像差し換え

	fetch("{{$sefl}}", {
        method: 'POST',
		mode: 'same-origin',
		headers: {
			'X-Requested-With': 'PaintBBS'
			,
		},
       body: formData
    })
    .then(response => {
	// console.log("response",response);
		if (response.ok) {

			if (response.redirected) {
				return window.location.href = response.url;
			}
			response.text().then((text) => {
				 //console.log(text);
				if (text.startsWith("error\n")) {
						console.log(text);
						return window.location.href = "?mode=piccom&stime={{$stime}}";
				}
			})
        }
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
		return window.location.href = "?mode=piccom&stime={{$stime}}";
    });
	@else
	return window.location.href = "?mode=piccom&stime={{$stime}}";
	@endif
	}
</script>


@else

<nav>
<div style= "min-width:calc({{$w}}px + 176px)" id="self2"> [<a href="{{$self2}}">{{$title}}</a>] 
@if($useneo) 
<span class="nts_radiowrap">工具
	<input type="radio" name="1" id="1" onclick="Neo.setToolSide(true)" class="nts_radio"><label class="ntslabel" for="1">置左</label>
	<input type="radio" name="1" id="2" onclick="Neo.setToolSide(false)" checked="checked" class="nts_radio"><label class="ntslabel" for="2">置右</label>
</span>
	@endif
</div>
</nav>
</header>
<!--動的パレットスクリプト ここから-->
<script>
//	BBS Note 動的パレット＆マトリクス 2003/06/22
//	(C) のらネコ WonderCatStudio http://wondercatstudio.com/
var DynamicColor = 1;	// パレットリストに色表示
var Palettes = new Array();
// パレット配列作成
@if($palettes) 
{!!htmlspecialchars($palettes,ENT_NOQUOTES)!!}
@endif
function setPalette(){d=document;d.paintbbs.setColors(Palettes[d.Palette.select.selectedIndex]);d.grad.view.checked&&GetPalette()}async function PaletteSave(){Palettes[0]=String(await document.paintbbs.getColors())}var cutomP=0;
async function PaletteNew(){d=document;p=String(await d.paintbbs.getColors());s=d.Palette.select;Palettes[s.length]=p;cutomP++;str=prompt("調色盤名稱","調色盤"+cutomP);null==str||""==str?cutomP--:(s.options[s.length]=new Option(str),30>s.length&&(s.size=s.length),PaletteListSetColor())}async function PaletteRenew(){d=document;Palettes[d.Palette.select.selectedIndex]=String(await d.paintbbs.getColors());PaletteListSetColor()}
function PaletteDel(){p=Palettes.length;s=document.Palette.select;i=s.selectedIndex;if(-1!=i&&(flag=confirm("「"+s.options[i].text + "」您要刪除嗎？"))){for(s.options[i]=null;p>i;)Palettes[i]=Palettes[i+1],i++;30>s.length&&(s.size=s.length)}}
async function P_Effect(a){a=parseInt(a);x=1;255==a&&(x=-1);d=document.paintbbs;p=String(await d.getColors()).split("\n");l=p.length;var f="";for(n=0;l>n;n++)R=a+parseInt("0x"+p[n].substring(1,3))*x,G=a+parseInt("0x"+p[n].substring(3,5))*x,B=a+parseInt("0x"+p[n].substring(5,7))*x,255<R?R=255:0>R&&(R=0),255<G?G=255:0>G&&(G=0),255<B?B=255:0>B&&(B=0),f+="#"+Hex(R)+Hex(G)+Hex(B)+"\n";d.setColors(f);PaletteListSetColor()}
async function PaletteMatrixGet(){d=document.Palette;p=Palettes.length;s=d.select;m=d.m_m.selectedIndex;t=d.setr;switch(m){default:t.value="";for(c=n=0;p>n;)null!=s.options[n]&&(t.value=t.value+"\n!"+s.options[n].text+"\n"+Palettes[n],c++),n++;alert("調色盤："+c+"\n已取得調色盤矩陣");break;case 1:t.value="!Palette\n"+String(await document.paintbbs.getColors()),
		alert("已取得當前使用的調色盤資訊")}t.value=
t.value.trim()+"\n!Matrix"}
function PalleteMatrixSet(){m=document.Palette.m_m.selectedIndex;str="設定調色盤矩陣。";switch(m){default:flag=confirm(str+"\n當前所有調色盤資訊都將丟失，可以嗎？");break;case 1:flag=confirm(str+"\n替換為當前使用的調色盤，可以嗎？");break;
case 2:flag=confirm(str+"\n添加到當前調色盤，可以嗎？")}flag&&(PaletteSet(),s.size=30>s.length?s.length:30,DynamicColor&&PaletteListSetColor())}
function PalleteMatrixHelp(){alert("★ PALETTE MATRIX\n什麼是調色盤矩陣？您可以通過取得調色盤矩陣的文本資訊來自由設定調色盤。\n\n□ 取得矩陣\n1）從“取得”按鈕獲取調色盤矩陣。\n2）取得的調色盤資訊將出現在下面的文本區域中，將其全部複製。\n3）您可以將此調色盤資訊另存在文本檔案中。\n\n□ 設定矩陣\n1）將復制的調色盤資訊貼到下面的文本輸入框中。\n2）如果已將其保存在文本檔案中，請複制並貼上。\n3）您可以通過按下“設定”按鈕使用保存的調色盤。\n\n請注意，如果有夾雜其他資訊，將無法正確設定調色盤。")}
function PaletteSet(){d=document.Palette;se=d.setr.value;s=d.select;m=d.m_m.selectedIndex;l=se.length;if(1>l)alert("沒有矩陣資訊。");else{e=o=n=0;switch(m){default:for(n=s.length;0<n;)n--,s.options[n]=null;case 2:i=s.options.length;n=se.indexOf("!",0)+1;if(0==n)return;Matrix1=1;for(Matrix2=-1;n<l;){e=se.indexOf("\n#",n);if(-1==e)return;pn=se.substring(n,e+Matrix1);o=se.indexOf("!",e);if(-1==o)return;pa=se.substring(e+1,o+Matrix2);
"Palette"!=pn?(0<=i&&(s.options[i]=new Option(pn)),Palettes[i]=pa,i++):document.paintbbs.setColors(pa);n=o+1}break;case 1:n=se.indexOf("!",0)+1;if(0==n)return;e=se.indexOf("\n#",n);o=se.indexOf("!",e);0<=e&&(pa=se.substring(e+1,o-1));document.paintbbs.setColors(pa)}PaletteListSetColor()}}function PaletteListSetColor(){var a=document.Palette.select;for(i=1;a.options.length>i;i++){var f=Palettes[i].split("\n");a.options[i].style.background=f[4];a.options[i].style.color=GetBright(f[4])}}
function GetBright(a){r=parseInt("0x"+a.substring(1,3));g=parseInt("0x"+a.substring(3,5));b=parseInt("0x"+a.substring(5,7));a=r>=g?r>=b?r:b:g>=b?g:b;return 128>a?"#FFFFFF":"#000000"}function Chenge_(){var a=document.grad.pst.value,f=document.grad.ped.value;isNaN(parseInt("0x"+a))||isNaN(parseInt("0x"+f))||GradView("#"+a,"#"+f)}
function ChengeGrad(){var a=document,f=a.grad.pst.value,h=a.grad.ped.value;Chenge_();var u=parseInt("0x"+f.substring(0,2)),v=parseInt("0x"+f.substring(2,4));f=parseInt("0x"+f.substring(4,6));var k=parseInt((u-parseInt("0x"+h.substring(0,2)))/15),q=parseInt((v-parseInt("0x"+h.substring(2,4)))/15);h=parseInt((f-parseInt("0x"+h.substring(4,6)))/15);isNaN(k)&&(k=1);isNaN(q)&&(q=1);isNaN(h)&&(h=1);var w=new String;cnt=0;m1=u;m2=v;for(m3=f;14>cnt;cnt++,m1-=k,m2-=q,m3-=h){if(255<m1||0>m1)k*=-1,m1-=k;if(255<m2||0>m2)q*=-1,
m2-=q;if(255<m3||0>m3)h*=-1,m2-=h;w+="#"+Hex(m1)+Hex(m2)+Hex(m3)+"\n"}a.paintbbs.setColors(w)}function Hex(a){a=parseInt(a);0>a&&(a*=-1);for(var f=new String,h;16<a;)h=a,16<a&&(a=parseInt(a/16),h-=16*a),h=Hex_(h),f=h+f;h=Hex_(a);for(f=h+f;2>f.length;)f="0"+f;return f}function Hex_(a){isNaN(a)?a="":10==a?a="A":11==a?a="B":12==a?a="C":13==a?a="D":14==a?a="E":15==a&&(a="F");return a}
async function GetPalette(){d=document;p=String(await d.paintbbs.getColors());"null"!=p&&""!=p&&(ps=p.split("\n"),st=d.grad.p_st.selectedIndex,ed=d.grad.p_ed.selectedIndex,d.grad.pst.value=ps[st].substring(1,7),d.grad.ped.value=ps[ed].substring(1,7),GradSelC(),GradView(ps[st],ps[ed]),PaletteListSetColor())}
function GradSelC(){if(d.grad.view.checked){d=document.grad;l=ps.length;pe="";for(n=0;l>n;n++)R=255+-1*parseInt("0x"+ps[n].substring(1,3)),G=255+-1*parseInt("0x"+ps[n].substring(3,5)),B=255+-1*parseInt("0x"+ps[n].substring(5,7)),255<R?R=255:0>R&&(R=0),255<G?G=255:0>G&&(G=0),255<B?B=255:0>B&&(B=0),pe+="#"+Hex(R)+Hex(G)+Hex(B)+"\n";pe=pe.split("\n");for(n=0;l>n;n++)d.p_st.options[n].style.background=ps[n],d.p_st.options[n].style.color=pe[n],d.p_ed.options[n].style.background=ps[n],d.p_ed.options[n].style.color=
pe[n]}}function GradView(a,f){d=document}function showHideLayer(){d=document;var a=d.layers?d.layers.psft:d.all("psft").style;d.grad.view.checked||(a.visibility="hidden");d.grad.view.checked&&(a.visibility="visible",GetPalette())};
</script>
<!--動的パレットスクリプト ここまで-->
<noscript><h3>由於 JavaScript 無效，因此無法正常工作</h3></noscript>
<div class="appstage"><div class="app" style="width:{{$w}}px; height:{{$h}}px">
<!--applet～の～部分の詳しい事は、PaintBBS及びしぃペインターのReadmeを参照-->
<!--PaintBBS個別設定-->
@if($paintbbs) 
<!-- NEOを使う時はアプレットを読み込まないように -->
@if($useneo) <applet-dummy @else<applet @endif

 CODE="pbbs.PaintBBS.class" ARCHIVE="./PaintBBS.jar" NAME="paintbbs" WIDTH="{{$w}}" HEIGHT="{{$h}}" MAYSCRIPT>
@if(isset($max_pch))
<param name="neo_max_pch" value="{{$max_pch}}">
@endif
<param name="neo_send_with_formdata" value="true">
<param name="neo_validate_exact_ok_text_in_response" value="true">
<param name="neo_confirm_layer_info_notsaved" value="true">
<param name="neo_confirm_unload" value="true">
<param name="neo_show_right_button" value="true">
<param name="neo_animation_skip" value="true">
<param name="neo_disable_grid_touch_move" value="true">
@endif
<!--しぃペインター個別設定-->
@if($normal) 
<applet code="c.ShiPainter.class" archive="spainter_all.jar" name="paintbbs" WIDTH="{{$w}}" HEIGHT="{{$h}}" MAYSCRIPT>
<param name=dir_resource value="./">
<param name="tt.zip" value="tt_def.zip">
<param name="res.zip" value="res.zip">
{{-- しぃペインターv1.05_9以前を使うなら res_normal.zip に変更 --}}
<param name=tools value="normal">
<param name=layer_count value="{{$layer_count}}">
@if($quality) 
<param name=quality value="{{$quality}}">
@endif
@endif
<!--しぃペインターPro個別設定-->
@if($pro) 
<applet code="c.ShiPainter.class" archive="spainter_all.jar" name="paintbbs" WIDTH="{{$w}}" HEIGHT="{{$h}}" MAYSCRIPT>
<param name=dir_resource value="./">
<param name="tt.zip" value="tt_def.zip">
<param name="res.zip" value="res.zip">
<param name=tools value="pro">
<param name=layer_count value="{{$layer_count}}">
@if($quality) 
<param name=quality value="{{$quality}}">
@endif
@endif
<!--共通設定(変更不可)-->
<param name="send_header_count" value="true">
<param name="send_header_timer" value="true">
<param name="image_width" value="{{$picw}}">
<param name="image_height" value="{{$pich}}">
<param name="image_jpeg" value="{{$image_jpeg}}">
<param name="image_size" value="{{$image_size}}">
<param name="compress_level" value="{{$compress_level}}">
<param name="undo" value="{{$undo}}">
<param name="undo_in_mg" value="{{$undo_in_mg}}">
<param name="poo" value="false">
<param name="send_advance" value="true">
<param name="tool_advance" value="true">
<param name="thumbnail_width" value="100%">
<param name="thumbnail_height" value="100%">
@if($useneo)
{{-- neo --}}
<param name="url_save" value="{{$self}}?mode=saveimage&amp;tool=neo">
<param name="send_header" value="usercode={{$usercode}}&amp;tool={{$tool}}">
<param name="url_exit" value="{{$self}}?mode={{$mode}}&amp;stime={{$stime}}">
@else
{{-- しぃペインター --}}
<param name="url_save" value="{{$self}}?mode=picpost">
<param name="send_header" value="usercode={{$usercode}}&amp;tool={{$tool}}&amp;rep={{$rep}}&amp;no={{$no}}&amp;pwd={{$pwd}}">
	@if($rep)
	<param name="url_exit" value="{{$self}}?res={{$oyano}}&amp;resid={{$no}}&amp;resid={{$no}}">
	@else
	<param name="url_exit" value="{{$self}}?mode=piccom&amp;stime={{$stime}}">
	@endif
@endif
@if($anime) 
<param name="thumbnail_type" value="animation">
@endif
@if($pchfile) 
<param name="pch_file" value="{{$pchfile}}">
@endif
@if($imgfile) 
<param name="image_canvas" value="{{$imgfile}}">
@endif
<!--共通設定(変更不可) ここまで-->
<!--アプレットのカラー設定(変更可)-->
<!--アプレットのカラー設定(変更可) ここまで-->
@if($useneo) 
</applet-dummy>
@else
</applet>
@endif
</div>
<!--動的パレット制御関連-->
<div class="palette_wrap">
<div class="palette"><FORM name="Palette">
<span class="palette_desc">PALETTE</span> <INPUT type="button" VALUE="暫存" OnClick="PaletteSave()"><br>
<select name="select" size="{{$palsize}}" onChange="setPalette()" class="palette_select">
<option>暫存的調色盤</option>
@if($dynp) 
@foreach ($dynp as $p)
	<option>{{$p}}</option>
@endforeach

@endif
@endif
@if($chickenpaint)
@else

</select><br>
<INPUT type="button" VALUE="新增" OnClick="PaletteNew()">
<INPUT type="button" VALUE="更新" OnClick="PaletteRenew()">
<INPUT type="button" VALUE="刪除" OnClick="PaletteDel()"><br>
<INPUT type="button" VALUE="變亮" OnClick="P_Effect(10)">
<INPUT type="button" VALUE="變暗" OnClick="P_Effect(-10)">
<INPUT type="button" VALUE="反轉" OnClick="P_Effect(255)">
	<hr class="palette_hr"><span class="palette_desc">MATRIX</span>
<SELECT name="m_m">
<option value="0">全部</option>
<option value="1">目前</option>
<option value="2">添加</option>
</SELECT><br>
<INPUT name="m_g" type="button" VALUE="取得" OnClick="PaletteMatrixGet()">
<INPUT name="m_s" type="button" VALUE="設定" OnClick="PalleteMatrixSet()">
<INPUT name="m_h" type="button" VALUE=" ? " OnClick="PalleteMatrixHelp()"><br>
<TEXTAREA rows="1" name="setr" cols="13" onMouseOver="this.select()"></TEXTAREA><br>
</FORM></div>
<div class="palette_gradation"><FORM name="grad">
	<label class="palette_desc checkbox" ><INPUT type="checkbox" name="view" OnClick="showHideLayer()" id="grdchk">GRADATION&nbsp;</label><INPUT type="button" VALUE=" OK " OnClick="ChengeGrad()"><br>
<SELECT name="p_st" onChange="GetPalette()">
<option>1</option>
<option>2</option>
<option>3</option>
<option>4</option>
<option>5</option>
<option>6</option>
<option>7</option>
<option>8</option>
<option>9</option>
<option>10</option>
<option>11</option>
<option>12</option>
<option>13</option>
<option>14</option>
</SELECT><input type="text" name="pst" size="8" onKeyPress="Chenge_()" onChange="Chenge_()"><br>
<SELECT name="p_ed" onChange="GetPalette()">
<option>1</option>
<option>2</option>
<option>3</option>
<option>4</option>
<option>5</option>
<option>6</option>
<option>7</option>
<option>8</option>
<option>9</option>
<option>10</option>
<option>11</option>
<option selected>12</option>
<option>13</option>
<option>14</option>
</SELECT><input type="text" name="ped" size="8" onKeyPress="Chenge_()" onChange="Chenge_()">
<div id="psft"></div>
</FORM></div>
<Script>
if(DynamicColor) PaletteListSetColor();
</Script>
</div>
</div>
<!--動的パレット制御関連 ここまで-->


<div class="centering">
<!--描画時間動的表示-->
<div class="applet_painttime">
<form name="watch">繪圖時間 
	<input type="text" size="20" name="count" class="input_count_timer" readonly>
</form>
<script>
	timerID=10;stime=new Date;function SetTimeCount(){now=new Date;s=Math.floor((now.getTime()-stime.getTime())/1E3);disp="";86400<=s&&(d=Math.floor(s/86400),disp+=d+"\u5929",s-=86400*d);3600<=s&&(h=Math.floor(s/3600),disp+=h+"\u5c0f\u6642",s-=3600*h);60<=s&&(m=Math.floor(s/60),disp+=m+"\u5206",s-=60*m);document.watch.count.value=disp+s+"\u79d2";clearTimeout(timerID);timerID=setTimeout(function() { SetTimeCount(); }, 250);};
	document.addEventListener('DOMContentLoaded',SetTimeCount,false);
</script>
	</div>
<!--描画時間動的表示 ここまで-->
<p>@if($anime) ★繪圖過程紀錄中★@endif</p>
<!--お絵かき設定値の再設定関連-->
<!--お絵かき設定値の再設定関連 ここまで-->
<a href="{{$self}}?mode=piccom" target="_blank" rel="noopener">未投稿的圖片</a>
</div>
<!--PaintBBS HELP START-->
<div class="paintbbs_memo">
  <div>基本操作（至少需要記住的功能）</div>
  <div>
    &lt;基本&gt;<br>
    在 PaintBBS 中，右鍵點擊、按住 Ctrl 鍵點擊或按住 Alt 鍵點擊的效果相同。<br>
    基本上只需點擊或右鍵點擊即可完成操作（使用貝茲曲線或複製工具時除外）。<br><br>
    &lt;工具列&gt;<br>
    大多數工具列按鈕可透過點擊切換功能，右鍵點擊則可切換回上一個功能。<br>
    調色盤顏色、遮罩顏色與暫存工具的狀態可透過右鍵點擊儲存。您也可以右鍵點擊以切換圖層的顯示與隱藏狀態。<br>
    左鍵點擊可取得調色盤的顏色或暫存工具中儲存的狀態。<br><br>
    &lt;畫布區域&gt;<br>
    右鍵點擊以吸取顏色。<br>
    在使用貝茲曲線或複製工具時，右鍵點擊會取消當前操作。
  </div>
  <br>
  <div>進階操作（不是必須，但記住會更順手的功能）</div>
  <div>
    &lt;工具列&gt;<br>
    拖曳時若滑鼠指標移出工具列，數值會緩慢變化，方便進行微調。<br>
    按住 Shift 鍵點擊調色盤，可將顏色恢復為預設狀態。<br>
    &lt;鍵盤快捷鍵&gt;<br>
    +：放大，-：縮小。<br>
    Ctrl + Z 或 Ctrl + U：復原，Ctrl + Alt + Z 或 Ctrl + Y：重做。<br>
    按 Esc 鍵可取消並重置貝茲曲線（與右鍵點擊相同）。<br>
    按住空白鍵可拖動畫布移動。<br>
    Ctrl + Alt + 拖動可調整筆觸寬度。<br><br>
    &lt;複製工具的進階用途&gt;<br>
    使用「複製」或「合併圖層」功能，可將內容移動至其他圖層。<br>
    先使用複製工具在原始圖層選取矩形區域，接著切換至目標圖層並繼續複製操作。<br>
    這樣即可在圖層之間移動內容。<br>
  </div>
  <br>
  <div>工具列按鈕與特殊功能簡介</div>
  <div>
    <ul>
      <li>筆尖（一般筆、水彩筆、文字）<br>
        可自由繪製線條或輸入文字。<br><br>
      </li>
      <li>筆尖2（網點、模糊等）<br>
        具備特殊效果的筆刷。<br><br>
      </li>
      <li>圖形（圓形與矩形）<br>
        用於繪製矩形與圓形等圖形。<br><br>
      </li>
      <li>特殊工具（複製、合併圖層、反轉等）<br>
        複製工具可選取範圍並拖曳以移動內容。<br><br>
      </li>
      <li>遮罩模式（正常、遮罩、反遮罩）<br>
        遮罩可禁止繪製特定顏色，反遮罩則相反。<br>
        「正常」表示未啟用遮罩功能。可透過右鍵點擊來更改遮罩顏色。<br><br>
      </li>
      <li>橡皮擦（筆形橡皮擦、方形橡皮擦、全部清除）<br>
        在透明圖層上填滿白色會遮蔽下層圖像。請使用橡皮擦來清除上層圖案。「全部清除」會移除所有圖案。<br>
        使用時選取工具後點擊畫布即可。<br>
        橡皮擦工具有獨立的寬度設定。<br><br>
      </li>
      <li>繪圖模式（手繪、直線、貝茲曲線）<br>
        不變更筆尖或功能，僅變更繪圖模式。僅適用於自由繪圖工具。<br><br>
      </li>
      <li>調色盤<br>
        點擊以取得顏色，右鍵點擊可設定顏色。Shift + 點擊可重設為預設值。<br><br>
      </li>
      <li>RGB 與 Alpha 控制條<br>
        可精確調整顏色與透明度。R 為紅、G 為綠、B 為藍、A 為透明度。<br>
        調整 Alpha 控制條可變更透明度。<br><br>
      </li>
      <li>筆寬調整工具<br>
        使用水彩筆時變更筆寬將套用預設 Alpha 值。<br><br>
      </li>
      <li>筆跡暫存工具<br>
        點擊以讀取線條設定，右鍵點擊可儲存設定（不含遮罩）。<br><br>
      </li>
      <li>圖層工具<br>
        PaintBBS 採用兩層透明畫布結構。<br>
        可在上層繪製線條，下層填色。<br>
        由於為「普通圖層」，使用鉛筆繪製的線條可為透明。<br>
        點擊以切換圖層，右鍵點擊可顯示或隱藏選中圖層。<br><br>
      </li>
    </ul>
  </div>
  關於投稿：
  <div>
    完成繪圖後，請使用「Send」按鈕投稿。<br>
    若投稿成功，將跳轉至指定的 URL。<br>
    若投稿失敗，僅會顯示錯誤訊息，並不會跳轉頁面。<br>
    若因處理時間過長而導致失敗，請稍後再試。<br>
    在這種情況下，可能會造成重複投稿，但這是 Web 伺服器或 CGI 程式方面的問題。
  </div>
</div>
<!--PaintBBS HELP END-->
@endif
@endif
{{-- お絵かきモード ここまで --}}
{{-- 動画表示モード --}}
{{-- 
// pch_mode…動画表示モードのとき true が入る
// paintbbs…PaintBBSのPCHファイルなら true が入る
// normal…しぃペインターのSPCHファイルなら true が入る
// w…アプレット領域サイズ(横)
// h…アプレット領域サイズ(縦)
// picw…キャンバスサイズ(横)
// pich…キャンバスサイズ(縦)
// pchfile…動画ファイル名(.pch or .spch)
// speed…動画再生スピード初期値
// datasize…動画ファイルサイズ(Byte)
--}}
@if($pch_mode) 
	</header>
<div class="appstage" style="width:{{$w}}px; height:{{$h}}px">
@if($paintbbs) 
@if($type_neo) <applet-dummy @else
<applet @endif
name="pch" code="pch.PCHViewer.class" archive="PCHViewer.jar,PaintBBS.jar" width="{{$w}}" height="{{$h}}" MAYSCRIPT>
@endif
@if($normal) 
<applet name="pch" code="pch2.PCHViewer.class" archive="PCHViewer.jar,spainter_all.jar" codebase="./" width="{{$w}}" height="{{$h}}">
<param name="res.zip" value="res.zip">
{{-- しぃペインターv1.05_9以前を使うなら res_normal.zip に変更 --}}
<param name="tt.zip" value="tt_def.zip">
<param name="tt_size" value="31">
@endif
<param name="image_width" value="{{$picw}}">
<param name="image_height" value="{{$pich}}">
<param name="pch_file" value="{{$pchfile}}">
<param name="speed" value="{{$speed}}">
<param name="buffer_progress" value="false">
<param name="buffer_canvas" value="false">
@if($type_neo) 
</applet-dummy>
@else
</applet>
@endif
	</div>
<div class="pch_download">
<A href="{{$pchfile}}" target="_blank" rel="nofollow noopener noreferrer">Download</A><br>
<small>Datasize : {{$datasize}} KB</small><br>
<a href="{{$self}}?res={{$oyano}}#{{$no}}">{{$title}}</a> / <a href="javascript:close()">關閉</a>
</div>
@endif
<!--動画表示モード ここまで-->
{{-- <!--コンティニューモード --> --}}
{{-- 
// continue_mode…コンティニューモードのとき true が入る
// home…ホームページURL
// self…POTI-boardのスクリプト名
// self2…入口(TOP)ページのURL
// picfile…画像URL
// picw…画像サイズ(横)
// pich…画像サイズ(縦)
// painttime…描画時間
// no…記事No
// pch…動画ファイル名
// ext…画像拡張子
// ctype_pch…動画より続きが描けるとき true が入る
// ctype_img…画像より続きが描けるとき true が入る
// applet…しぃペインターが使用できるとき true が入る
// usepbbs…しぃペインターとPaintBBSの両方が使用できるとき true が入る
// palette…パレット選択用データ(selectタグ用option配列)
--}}

@if($continue_mode) 

<nav>
<div id="self2">
	[<a href="{{$self}}?res={{$oyano}}#{{$no}}">{{$title}}</a>]
</div>
</nav>
</header>
 	<div class="centering">
    <!--クッキー読込み用JavaScript(必須)-->
    <Script src="loadcookie.js?{{$ver}}"></script>
    <!--画像と描画時間-->
 	<div class="continue_img">
<img src="{{$picfile}}" width="{{$picw}}" height="{{$pich}}" alt="@if($sub){{$sub}} @endif @if($name) by {{$name}} @endif{{$picw}} x {{$pich}}" title="@if($sub){{$sub}} @endif @if($name) by {{$name}} @endif{{$picw}} x {{$pich}}">
   </div>
    <div class="continue_painttime">@if($painttime) 繪圖時間：{{$painttime}}@endif</div>
    <!--コンティニューフォーム欄-->
	<div class="continue_post_form">
	@if($download_app_dat)
	<form action="{{$self}}" method="post">
		<input type="hidden" name="mode" value="download">
		<input type="hidden" name="no" value="{{$no}}">
		<span class="input_disp_none"><input type="text" value="" autocomplete="username"></span>
		<span class="nk">密碼<input type="password" name="pwd" value="" class="paint_password" autocomplete="current-password"></span>
		<input type="submit" value="下載 {{$pch_ext}} 文件">
		</form>
	@endif	  
		
	<form action="{{$self}}" method="post">
      <input type="hidden" name="mode" value="contpaint">
      <input type="hidden" name="anime" value="true">
      <input type="hidden" name="picw" value="{{$picw}}">
      <input type="hidden" name="pich" value="{{$pich}}">
      <input type="hidden" name="no" value="{{$no}}">
      <input type="hidden" name="pch" value="{{$pch}}">
      <input type="hidden" name="ext" value="{{$ext}}">
      <span class="nk">
      <select name="ctype" class="paint_select">
        @if($ctype_pch) <option value="pch">使用過程繼續繪圖</option>@endif
        @if($ctype_img) <option value="img">使用圖片繼續繪圖</option>@endif
      </select>
    <select name="type" class="paint_select" id="select_post">
	<option value="rep">替換舊圖</option>
	<option value="new">新投稿</option>
       </select>
       </span>
	   <span class="nk" id="span_cont_paint_same_thread">
		<input type="checkbox" name="cont_paint_same_thread" id="cont_paint_same_thread" value="on" checked="checked"><label for="cont_paint_same_thread" class="bold_gray">投稿到同一線程</label>
	</span>
      <br>
{{-- 
//select_app ツールの選択メニューを出す時にtrueが入る
//use_shi_painter しぃペインターを使う設定の時にtrueが入る
//use_chickenpaint を使う設定の時にtrueが入る
//app_to_use 動画やレイヤー情報などの固有形式があるときに対応するアプリが入る
 --}}

 @if($select_app)
 <select name="shi" class="paint_select">
	@if($use_neo)<option value="neo">PaintBBS NEO</option>@endif
	@if($use_tegaki)<option value="tegaki">Tegaki</option>@endif
	@if($use_axnos)<option value="axnos">Axnos Paint</option>@endif
	@if($use_shi_painter)<option value="1" class="for_pc">Shi-Painter</option>@endif
	@if($use_chickenpaint)<option value="chicken">ChickenPaint</option>@endif
	@if($use_klecks)<option value="klecks">Klecks</option>@endif
 </select>
 @endif 
 {{-- 選択メニューを出さない時に起動するアプリ --}}
 @if($app_to_use)
 <input type="hidden" name="shi" value="{{$app_to_use}}">
 @endif

@if($use_select_palettes) 
<span class="palette_type">PALETTE</span> <select name="selected_palette_no" title="パレット" class="paint_select palette_type">{!!$palette_select_tags!!}</select>
@endif
<span class="input_disp_none"><input type="text" value="" autocomplete="username"></span>
<span class="nk" id="span_cont_pass">密碼<input type="password" name="pwd" value="" class="paint_password" autocomplete="current-password"></span>
<input type="submit" value="續繪">

</form>
</div>
<!--コンティニュー説明-->
<div class="howtocontinue">
		<ul id="up_desc">
@if($newpost_nopassword) 
<li>如果是新投稿，則可以在沒有密碼的的情況下續繪。</li>
@else
<li>您必須輸入設定的續繪密碼才能繼續繪圖。</li>
@endif
	</ul>
</div>

<script>
	// 新規投稿時にのみ、同じスレッドに投稿するボタンを表示
	document.getElementById('select_post').addEventListener('change', function() {
		const idx=document.getElementById('select_post').selectedIndex;
		console.log(idx);
		const cont_paint_same_thread=document.getElementById('span_cont_paint_same_thread');
		const cont_pass=document.getElementById('span_cont_pass');
		if(idx === 1){
			if(cont_paint_same_thread){
				cont_paint_same_thread.style.display = "inline-block";
			}
			@if($newpost_nopassword) 
			if(cont_pass){
			cont_pass.style.display = "none";
			}
			@endif
		}else{
			if(cont_paint_same_thread){
				cont_paint_same_thread.style.display = "none";
			}
			@if($newpost_nopassword) 
			if(cont_pass){
				cont_pass.style.display = "inline-block";
			}
			@endif
		}
	});
</script>

<!--JavaScriptの実行(クッキーを読込み、フォームに値をセット)-->
<script>
	document.addEventListener('DOMContentLoaded',l,false);
</script>
</div>
<script src="lib/{{$jquery}}"></script>
<script src="{{$skindir}}js/basic_common.js?{{$ver}}"></script>
@endif
<!--コンティニューモード ここまで--><!--著作権表示 削除しないでください-->
<footer>
	{{-- <!--著作権表示 削除しないでください--> --}}
	@include('parts.copyright')
</footer>
</body>
</html>
