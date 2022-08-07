<!DOCTYPE html>
<html lang="zh-Hant-TW">
<head>
	<meta charset="utf-8">
	{{-- <!--SNS--> --}}
	@if ($sharebutton)
	<meta name="Description" content="{{$oya[0][0]['descriptioncom']}}">

	<meta name="twitter:card" content="summary" />
	<meta property="og:title"
		content="[{{$oya[0][0]['no']}}] {{$oya[0][0]['sub']}} by {{$oya[0][0]['name']}} - {{$title}}" />
	<meta property="og:type" content="article" />
	<meta property="og:url" content="{{$rooturl}}{{$self}}?res={{$oya[0][0]['no']}}" />
	@if ($oya[0][0]['src'])
	<meta property="og:image" content="{{$rooturl}}{{$oya[0][0]['imgsrc']}}" />
	@endif
	<meta property="og:site_name" content="" />
	<meta property="og:description" content="{{$oya[0][0]['descriptioncom']}}" />
	@endif
	<!--ENDSNS-->
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
	<link rel="stylesheet" href="{{$skindir}}basic.css">
	<link rel="stylesheet" href="{{$skindir}}icomoon/style.css">
	<link rel="preload" as="script" href="lib/{{JQUERY}}">
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

	<title>[{{$oya[0][0]['no']}}] {{$oya[0][0]['sub']}} by {{$oya[0][0]['name']}} - {{$title}}</title>
	{{-- <!--
// title…掲示板タイトル
// charset…文字コード
--> --}}
	{{-- <!--クッキー読込み用JavaScript(必須)--> --}}
	<link rel="preload" as="script" href="loadcookie.js">
</head>

<body>
	<div id="top"></div>
	<div id="body">
		<header>
			<h1 id="bbs_title">[{{$oya[0][0]['no']}}] {{$oya[0][0]['sub']}} <span class="title_name_wrap">by
					{{$oya[0][0]['name']}} 回覆</span></h1>
			<nav>
				<div id="self2">
					[<a href="{{$self2}}">{{$title}}</a>]
					<span class="menu_home_wrap">
						[<a href="{{$home}}" target="_top">HOME</a>]</span>
					<a href="#bottom">▽</a>
				</div>
			</nav>
			{{-- <!--
	// home…ホームページURL
	// self…POTI-boardのスクリプト名
	// self2…入口(TOP)ページのURL
	// resno…レス時の親記事No
	--> --}}
		</header>

		@foreach ($oya as $i=>$ress)

		{{-- <!--親記事グループ--> --}}
		{{-- 個別スレッドのループここから --}}
		{{-- スレッドのループ --}}
		{{-- <!--親記事グループ--> --}}
		<article>
			@if(isset($ress) and !@empty($ress))
		
			@foreach ($ress as $res)
			{{-- <!--親記事ヘッダ--> --}}
			@if ($loop->first)
			{{-- 最初のループ --}}
			<h2 class="article_title">[{{$ress[0]['no']}}]
					{{$ress[0]['sub']}}</h2>
		
			@else
			<hr>
			{{-- <!-- レス記事ヘッダ --> --}}
			<div class="res_article_wrap">
				<div class="res_article_title">[{{$res['no']}}] {{$res['sub']}}</div>
				@endif
				{{-- <!-- 記事共通ヘッダ --> --}}
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

		
					{{-- <!-- 記事共通ヘッダここまで --> --}}
		
					@if($res['src'])<div class="posted_image" @if($res['w']>=750) style="margin-right:0;float:none;" @endif >
						@if($res['thumb'])<a href="{{$res['src']}}" target="_blank" rel="noopener">@endif<img
								src="{{$res['imgsrc']}}" width="{{$res['w']}}" height="{{$res['h']}}"
								alt="{{$res['sub']}} by {{$res['name']}} ({{$res['size']}} B)"
								title="{{$res['sub']}} by {{$res['name']}} ({{$res['size']}} B) @if($res['thumb'])縮圖顯示 @endif"
								loading="lazy">@if($res['thumb'])</a>@endif
					</div>
					@endif
					<div class="comment"> {!!$res['com']!!}</div>
					{{-- // $res/tab…TAB順用連番
					// $res/imgsrc…サムネイルがあるとき、サムネイルURL。サムネイルがないとき、画像URL
					// $res/w…画像サイズ(横)
					// $res/h…画像サイズ(縦)
					// $res/srcname…画像ファイル名
					// $res/size…画像ファイルサイズ
					// $res/com…本文 --}}
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
							{{-- ここまで --}}
			<div class="clear"></div>
			<div class="margin_resbutton_res">
				<div class="res_button_wrap">
					@if($form)
					@if($resname)
					<script>
						function add_to_com() {
							document.getElementById("p_input_com").value +=
							"{!! htmlspecialchars($resname,ENT_QUOTES,'utf-8') !!}{{$_san}}";
						}
					</script>

					{{-- <!--コピーボタン--> --}}
					<button class="copy_button" onclick="add_to_com()">複製投稿者名稱</button>
					@endif
					@endif

					@if($sharebutton)
					{{-- シェアボタン --}}
					<span class="share_button">
						<a target="_blank"
							href="https://twitter.com/intent/tweet?text=%5B{{$ress[0]['encoded_no']}}%5D%20{{$ress[0]['share_sub']}}%20by%20{{$ress[0]['share_name']}}%20-%20{{$encoded_title}}&url={{$encoded_rooturl}}{{$encoded_self}}?res={{$ress[0]['encoded_no']}}"><span
								class="icon-twitter"></span>tweet</a>
						<a target="_blank" class="fb btn"
							href="http://www.facebook.com/share.php?u={{$encoded_rooturl}}{{$encoded_self}}?res={{$ress[0]['encoded_no']}}"><span
								class="icon-facebook2"></span>share</a>
					</span>
					@endif

					<span class="page_top"><a href="#top">△</a></span>

				</div>
			</div>
			<!-- /thread -->
		</article>
		@endforeach
		{{-- <!--親記事グループここまで--> --}}
		<div class="clear"></div>
		{{-- <!--お絵かきフォーム欄--> --}}
		@if($paintform)
		{{-- <!--実際のお絵かきフォーム--> --}}
		@if($paint)
		<div id="res_paint_form">

			@include('parts.paint_form', ['ress' => $ress])

		</div>

		@endif
		@endif

		{{-- <!--投稿フォーム欄--> --}}
		@if($form)
		<form action="{{$self}}" method="POST" enctype="multipart/form-data" id="post_form">
			<input type="hidden" name="token" value="{{$token}}">
			<input type="hidden" name="mode" value="regist">
			<input type="hidden" name="resto" value="{{$resno}}">
			<input type="hidden" name="MAX_FILE_SIZE" value="{{$maxbyte}}">
			{{-- <!--
			// maxbyte…最大投稿サイズ(Byte)
			--> --}}
			<table id="post_table">
				<tr>
					<td class="post_table_title">名稱 @if($usename) (必需) @endif</td>
					<td><input type="text" name="name" class="post_input_text" autocomplete="username"></td>
				</tr>
				<tr>
					<td class="post_table_title">E-mail</td>
					<td><input type="text" name="email" class="post_input_text" autocomplete="email"></td>
				</tr>
				<tr>
					<td class="post_table_title">URL</td>
					<td><input type="url" name="url" class="post_input_text" autocomplete="url"></td>
				</tr>
				<tr>
					<td class="post_table_title">標題 @if($usesub) (必需) @endif</td>
					<td><input type="text" name="sub" value="{{$resub}}" class="post_input_text" autocomplete="off">
					</td>
				</tr>
				<tr>
					<td class="post_table_title">內文@if($usecom) (必需) @endif</td>
					<td><textarea name="com" class="post_input_com" id="p_input_com"></textarea></td>
				</tr>
				{{-- <!--
				// usename…名前が必須だと ' *' が入る
				// usesub…題名が必須だと ' *' が入る
				// usecom…本文が必須だと ' *' が入る
				// resub…レス時の返信用題名(Re: ～)
				// --> --}}
				{{-- <!--ファイルアップロード欄--> --}}
				@if($upfile)

				<tr>
					<td class="post_table_title">附加圖片</td>
					<td><input type="file" name="upfile" accept="image/*">
					</td>
				</tr>
				@endif
				<tr>
					<td class="post_table_title">密碼</td>
					<td><input type="password" name="pwd" value="" class="post_input_pass"
							autocomplete="current-password">
						<span class="howtoedit">(用於編輯和删除文章，請使用英數組合)</span>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align: center;" class="post_table_submit td_noborder"><input
							type="submit" value="送出" class="post_submit"></td>
				</tr>
				<tr>
					<td colspan="2" class="td_noborder">
						<!--ファイルアップロード時の説明-->
						@if($upfile)
						<ul class="howtowrite">
							<li>圖片檔案大小限制為 {{$maxkb}} KB。</li>
							{!!$addinfo!!}
						</ul>
						@endif
					</td>
				</tr>
			</table>
		</form>
		@endif
		<hr>

		<nav>
			<div class="pagelink pcdisp">
				@if($res_prev)<a href="{{$self}}?res={{$res_prev['no']}}">≪{{$res_prev['substr_sub']}}</a>@endif
				<div class="pagelink_top"><a href="{{$self2}}">留言板頂部</a></div>
				@if($res_next)<a href="{{$self}}?res={{$res_next['no']}}">
					{{$res_next['substr_sub']}}≫</a>@endif
			</div>
			<div class="mobiledisp">
				@if($res_prev)
				上一頁: <a href="{{$self}}?res={{$res_prev['no']}}">{{$res_prev['sub']}}</a>
				<br>
				@endif
				@if($res_next)
				下一頁: <a href="{{$self}}?res={{$res_next['no']}}">{{$res_next['sub']}}</a>
				<br>
				@endif
			</div>
@if($view_other_works)
<div class="view_other_works">
@foreach($view_other_works as $view_other_work)<div><a
 href="{{$self}}?res={{$view_other_work['no']}}"><img src="{{$view_other_work['imgsrc']}}" alt="{{$view_other_work['sub']}} by {{$view_other_work['name']}}" title="{{$view_other_work['sub']}} by {{$view_other_work['name']}}" width="{{$view_other_work['w']}}" height="{{$view_other_work['h']}}" loading="lazy"></a></div>@endforeach
</div>
@endif

		</nav>

		{{-- <!-- メンテナンスフォーム欄 --> --}}
		@include('parts.mainte_form')
		<script src="loadcookie.js"></script>
		<script>
		document.addEventListener('DOMContentLoaded',l,false); //LoadCookie
		</script>
	
		<footer>
			{{-- <!--著作権表示 削除しないでください--> --}}
			@include('parts.copyright')
		</footer>
		<div id="bottom"></div>
		<div id="page_top"><a href="#" class="icon-angles-up-solid"></a></div>
		<script src="lib/{{JQUERY}}"></script>
		<script>
		jQuery(function() {
			window.onpageshow = function () {
				var $btn = $('[type="submit"]');
				//disbledを解除
				$btn.prop('disabled', false);
				$btn.click(function () { //送信ボタン2度押し対策
					$(this).prop('disabled', true);
					$(this).closest('form').submit();
				});
			}
				// https://cotodama.co/pagetop/
			var pagetop = $('#page_top');   
			pagetop.hide();
			$(window).scroll(function () {
				if ($(this).scrollTop() > 100) {  //100pxスクロールしたら表示
					pagetop.fadeIn();
				} else {
					pagetop.fadeOut();
				}
			});
			pagetop.click(function () {
				$('body,html').animate({
					scrollTop: 0
				}, 500); //0.5秒かけてトップへ移動
				return false;
			});
		});
		</script>
</div>
</body>
</html>