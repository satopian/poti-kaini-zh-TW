{{-- <!--********** メインテンプレート **********
// このテンプレートは、以下のモード用テンプレートです
// ・メインモード
--> --}}
<!DOCTYPE html>
<html lang="zh-Hant-TW">

<head>
	<meta charset="utf-8">
	{{-- SNS --}}
	@if ($sharebutton)
	<meta name="twitter:card" content="summary">
	<meta name="twitter:site" content="">
	<meta property="og:site_name" content="">
	<meta property="og:title" content="{{$title}}">
	<meta property="og:type" content="article">
	<meta property="og:description" content="">
	<meta property="og:image" content="">
	@endif
	{{--  ENDSNS --}}
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
	<link rel="stylesheet" href="{{$skindir}}basic.css?{{$ver}}">
	<link rel="preload" as="style" href="{{$skindir}}icomoon/style.css" onload="this.rel='stylesheet'">
	<link rel="preload" as="script" href="lib/{{$jquery}}">
	<link rel="preload" as="style" href="lib/luminous/luminous-basic.min.css" onload="this.rel='stylesheet'">
	<link rel="preload" as="script" href="lib/luminous/luminous.min.js">
	<link rel="preload" as="script" href="{{$skindir}}js/basic_common.js">
	<link rel="preload" as="script" href="loadcookie.js">
	<style id="for_mobile"></style>
	<script>
		function is_mobile() {
			if (navigator.maxTouchPoints && (window.matchMedia && window.matchMedia('(max-width: 768px)').matches)){
				return	document.getElementById("for_mobile").textContent = ".for_pc{display: none;}";
			}
			return false;
		}
		document.addEventListener('DOMContentLoaded',is_mobile,false);
	</script>
<title>{{$title}}</title>
	{{-- title…掲示板タイトル --}}
</head>

<body>
	<div id="top"></div>
	<div id="body">
		<header>
			<h1 id="bbs_title">{{$title}}</h1>
			{{-- resnoがある＝レスモード --}}
			<nav>
				<div class="bbsmenu">
					[<a href="{{$home}}" target="_top">HOME</a>]
					[<a href="{{$self}}?mode=catalog">目錄</a>]
					@if ($for_new_post)
					[<a href="{{$self}}?mode=newpost">投稿</a>]
					@endif
					[<a href="{{$self}}?mode=piccom">未<span class="menu_none">投稿的圖片</span></a>]
					[<a href="{{$self}}?mode=admin">管<span class="menu_none">理</span></a>]
					<a href="#bottom">▽</a>
			{{-- 
			// home…ホームページURL
			// self…POTI-boardのスクリプト名
			// self2…入口(TOP)ページのURL
			// resno…レス時の親記事No
			 --}}
			</div>
			</nav>
			{{--  1行広告用  --}}
			<div class="menu_pr"></div>
			<div class="clear"></div>
			{{-- お絵かきフォーム欄
			//実際のお絵かきフォーム
			//select_app ツールの選択メニューを出す時にtrueが入る
			//use_shi_painter しぃペインターを使う設定の時にtrueが入る
			//use_chickenpaint を使う設定の時にtrueが入る
			 --}}

		@if ($paint and !$diary)
			{{-- ペイントボタン --}}

			<form action="{{$self}}" method="post" enctype="multipart/form-data" class="paint_form" id="paint_form">
				<input type="submit" value="PAINT" class="paint_button">
			@if($select_app)
			<span class="bold_gray">Tool</span>
			<select name="shi" class="select_applet">
				@if ($use_neo)<option value="neo">PaintBBS NEO</option>@endif
				@if ($use_shi_painter)<option value="1" class="for_pc">Shi-Painter</option>@endif
				@if ($use_chickenpaint)<option value="chicken">ChickenPaint</option>@endif
				@if ($use_klecks)<option value="klecks">Klecks</option>@endif
			</select>
			@endif 
			{{-- <!-- 選択メニューを出さない時に起動するアプリ --> --}}
			@if($app_to_use)
			<input type="hidden" name="shi" value="{{$app_to_use}}">
			@endif

			{{--  キャンバスサイズ 設定はconfig.phpで --}}
			<span class="canvas_size_wrap">
			<span class="bold_gray">Size</span>
				<select name="picw" title="寬" class="canvas_select">
				{{-- 幅 300から、PMAX_W で設定した最大値まで。 --}}
					@for($i = 300; $i <=$pmaxw ; $i+=50){{-- 50ずつ増える --}}
					@if($pdefw==$i){{-- デフォルトサイズ --}}
					<option value="{{$i}}" selected>{{$i}}</option>
					@else
					<option value="{{$i}}">{{$i}}</option>
					@endif
					@endfor
				</select>
				x
				<select name="pich" title="高" class="canvas_select">
					@for($i = 300; $i <=$pmaxh ; $i+=50){{-- 50ずつ増える --}}
					@if($pdefh==$i){{-- デフォルトサイズ --}}
					<option value="{{$i}}" selected>{{$i}}</option>
					@else
					<option value="{{$i}}">{{$i}}</option>
					@endif
					@endfor
				</select> 
			</span>
			{{-- キャンバスサイズ ここまで --}}

			@if ($use_select_palettes)
				<span class="palette_type bold_gray">PALETTE</span> <select name="selected_palette_no" title="PALETTE" class="canvas_select palette_type">{!!$palette_select_tags!!}</select>
			@endif
			@if ($anime)<label class="checkbox use_animation"><input type="checkbox" value="true" name="anime" {{$animechk}}>保存過程</label>
			@endif
				{{-- 
				//  anime…動画記録機能を使用するとき true が入る
				//  animechk…動画記録をデフォルトでチェックするとき ' checked' が入る
				//  --}}
				@if($resno)<input type="hidden" name="resto" value="{{$resno}}">@endif
			<input type="hidden" name="mode" value="paint">
			</form>

			{{-- 
			// config.phpで設定した
			// //お絵描きデフォルトサイズ(最初に選択される数値)
			// PDEF_W //幅
			// PDEF_H// 高さ
			// //お絵描き最大サイズ
			// PMAX_W //幅
			// PMAX_H //高さ
			// が入ります。
			// --> --}}
		@endif

			{{-- お絵かきフォーム欄のみ時に表示 --}}
			@if (!$diary or $addinfo)
			<div class="howtopaint">
				<ul id="up_desc">
					@if ($paint2 and !$diary)
					<li>畫布尺寸需設定在宽 300 至 {{$pmaxw}} px 和高 300px 至 {{$pmaxh}}px間。</li>
					<li>當寬超過 {{$maxw}}px，高超過 {{$maxw}}px，圖片將會按比例縮小顯示。</li>
					@endif
					{!!$addinfo!!}
				</ul>
			</div>
			@endif
		{{-- 
		// pmaxw…お絵かき最大サイズ(横)
		// pmaxh…お絵かき最大サイズ(縦)
		// maxw…投稿サイズ(横)。レス時にはレス用の値が入る
		// maxh…投稿サイズ(縦)。レス時にはレス用の値が入る
		// addinfo…追加お知らせ
		--}}
	</header>
		{{-- 前、次のナビゲーション --}}
		@include('parts.prev_next')

		@foreach ($oya as $i=>$ress)

{{-- スレッドのループ --}}
{{-- 親記事グループ --}}
<article>
	@if(isset($ress) and !@empty($ress))
		
	@foreach ($ress as $res)
	{{-- 親記事ヘッダ --}}
	@if ($loop->first)
	{{-- 最初のループ --}}
	<h2 class="article_title"><a href="{{$self}}?res={{$ress[0]['no']}}">[{{$ress[0]['no']}}]
			{{$ress[0]['sub']}}</a></h2>

	@else
	<hr>
	{{-- レス記事ヘッダ --}}
	<div class="res_article_wrap">
		<div class="res_article_title">[{{$res['no']}}] {{$res['sub']}}</div>
		@endif
		{{-- 記事共通ヘッダ --}}
		@if(!isset($res['not_deleted'])||$res['not_deleted'])
		<div class="article_info">
			<span class="article_info_name"><a href="search.php?page=1&imgsearch=on&query={{$res['encoded_name']}}&radio=2"
					target="_blank" rel="noopener">{{$res['name']}}</a></span>@if($res['url'])<span
				class="article_info_desc">[<a href="{{$res['url']}}" target="_blank"
					rel="nofollow noopener noreferrer">URL</a>]</span> @endif
			@if($res['id'])<span class="article_info_desc">ID:{{$res['id']}}</span>@endif
			<span class="article_info_desc">{{$res['now']}}</span>@if($res['painttime'])<span
				class="article_info">繪圖時間:{{$res['painttime']}}</span>@endif
			@if($res['updatemark'])<span class="article_info_desc">{{$res['updatemark']}}</span>@endif
			@if($res['thumb'])<span class="article_info_desc">- 縮圖顯示 -</span>@endif
			<div class="article_img_info">
				@if($res['src'])
				@if($res['continue'])<span class="article_info_continue">☆<a
						href="{{$self}}?mode=continue&no={{$res['continue']}}">續繪</a></span>@endif
				@if($res['spch'])<span class="for_pc">@endif @if($res['pch'])@if($res['continue'])| @endif<span
						class="article_info_animation">☆<a href="{{$self}}?mode=openpch&pch={{$res['pch']}}"
							target="_blank">過程</a></span>@endif @if($res['spch'])</span>@endif
				@endif			
			</div>
		</div>
		@endif
			{{-- 記事共通ヘッダここまで --}}

			@if($res['src'])<div class="posted_image" @if($res['w']>=750) style="margin-right:0;float:none;" @endif >
				<a href="{{$res['src']}}" target="_blank" rel="noopener" class="luminous"><img
						src="{{$res['imgsrc']}}" width="{{$res['w']}}" height="{{$res['h']}}"
						alt="{{$res['sub']}} by {{$res['name']}} ({{$res['size_kb']}} KB)"
						title="{{$res['sub']}} by {{$res['name']}} ({{$res['size_kb']}} KB) @if($res['thumb'])縮圖顯示 @endif"
						@if($i>4)loading="lazy"@endif></a>
			</div>
			@endif
			<div class="comment">{!!$res['com']!!}</div>

			{{-- // $res/tab…TAB順用連番
			// $res/imgsrc…サムネイルがあるとき、サムネイルURL。サムネイルがないとき、画像URL
			// $res/w…画像サイズ(横)
			// $res/h…画像サイズ(縦)
			// $res/srcname…画像ファイル名
			// $res/size…画像ファイルサイズ
			// $res/com…本文 --}}
			@endif
			@if(isset($res['not_deleted'])&&!$res['not_deleted'])
			這個貼文不存在。
			@endif

			@if ($loop->first)
			@if ($res['skipres'])
			<hr>
			<div class="article_skipres">{{$res['skipres']}}個回覆已被省略。</div>
			@endif
			@endif
	@if (!$loop->first)
	</div>
	@endif

	@endforeach
	@endif

			<div class="clear"></div>
			<div class="margin_resbutton_res">
				<div class="res_button_wrap">

					@if($sharebutton)
					{{-- シェアボタン --}}
					<span class="share_button">
						<a target="_blank"
						href="https://twitter.com/intent/tweet?text={{$ress[0]['encoded_t']}}&url={{$ress[0]['encoded_u']}}"><span
						class="icon-twitter"></span>Tweet</a>
						<a target="_blank" class="fb btn"
						href="http://www.facebook.com/share.php?u={{$ress[0]['encoded_u']}}"><span
						class="icon-facebook2"></span>Share</a>
					</span>
					@endif
					<form action="{{$self}}?res={{$ress[0]['no']}}" method="post"><input type="submit"
						value="@if($ress[0]['disp_resbutton']) 回覆 @else 顯示 @endif" class="res_button"></form></div>
			</div>
			{{-- end thread --}}
		</article>
		<hr>

		@endforeach
		{{-- 親記事グループここまで --}}
		<div class="clear"></div>

		{{-- メイン時ページング表示 --}}
		<div id="paging_wrap">{!!$paging!!}</div>

		{{-- 前、次のナビゲーション --}}
		@include('parts.prev_next')
		{{-- メンテナンスフォーム欄 --}}
		@include('parts.mainte_form')

		<footer>
			{{-- 著作権表示 削除しないでください --}}
			@include('parts.copyright')
		</footer>
	</div>
	<script src="loadcookie.js"></script>
	<script>
		document.addEventListener('DOMContentLoaded',l,false);
	</script>
	<div id="bottom"></div>
	<div id="page_top"><a class="icon-angles-up-solid"></a></div>
	<script src="lib/{{$jquery}}"></script>
	<script src="lib/luminous/luminous.min.js"></script>
	<script src="{{$skindir}}js/basic_common.js"></script>
</body>

</html>
