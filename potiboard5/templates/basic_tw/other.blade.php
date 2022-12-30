{{-- ********** その他テンプレート **********
// このテンプレートは、以下のモード用テンプレートです
// ・投稿モード
// ・管理モード(認証)モード
// ・管理モード(削除)モード
// ・エラーモード
--}}
<!DOCTYPE html>
<html lang="zh-Hant-TW">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
	<link rel="stylesheet" href="{{$skindir}}basic.css">
	<link rel="preload" as="style" href="{{$skindir}}icomoon/style.css" onload="this.rel='stylesheet'">
	<link rel="preload" as="script" href="lib/{{$jquery}}">
	<link rel="preload" as="style" href="lib/luminous/luminous-basic.min.css" onload="this.rel='stylesheet'">
	<link rel="preload" as="script" href="lib/luminous/luminous.min.js">
	<title>@if($post_mode and !$rewrite) 投稿表單 @endif @if($rewrite)
		編輯模式 @endif @if($admin_in) 對於管理 @endif @if($admin) @endif @if($admin) 管理人投稿 @endif
		@if($admin_del) 刪除文章 @endif @if($err_mode) 錯誤！ @endif - {{$title}} </title>
	{{--  
// title…掲示板タイトル
 --}}
 <style>
	.del_page {
		display: inline-block;
	}
	.pchup_button {
	margin: 0 0 10px 0;
	}
	</style>
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
</head>

<body>
	<div id="body">
		<header>
			<h1 id="bbs_title">@if($post_mode and !$rewrite) 投稿表單 @endif @if($rewrite)
				編輯模式 @endif @if($admin_in) 對於管理 @endif @if($admin) @endif @if($admin) 管理人投稿
				@endif @if($admin_del) 刪除文章 @endif @if($err_mode) 錯誤！ @endif - <span
					class="title_name_wrap">{{$title}}</span></h1>
			{{-- <!-- 
投稿モード
// 【新規投稿、お絵かき投稿、編集】
//
// post_mode…投稿モードのとき true が入る
// regist…新規投稿のとき true が入る
// admin…管理モードのとき 管理者パスワード が入る
// home…ホームページURL
// self…POTI-boardのスクリプト名
// self2…入口(TOP)ページのURL
// pictmp…お絵かき投稿モードフラグ。通常投稿:0、お絵かき絵なし:1、お絵かき絵あり:2
// notmp…お絵かき投稿時に絵がなかったとき true が入る
// tmp…一時保存絵用配列
// tmp/src…一時保存絵URL
// tmp/srcname…一時保存絵ファイル名
// tmp/date…一時保存絵保存日
// ptime…描画時間
// rewrite…編集のとき 記事No が入る
// pwd…編集のとき 記事Pass が入る
// resno…お絵かきレス時 レス記事No が入る
// maxbyte…最大投稿サイズ(Byte)
// maxkb…最大投稿サイズ(KB)
// ipcheck…IPチェック機能がONのとき true が入る
// usename…名前が必須だと ' *' が入る
// usesub…題名が必須だと ' *' が入る
// usecom…本文が必須だと ' *' が入る
// name…編集用の投稿者名
// email…編集用のメールアドレス
// url…編集用のURL
// sub…編集用の題名
// com…編集用の本文
// fctable…文字色配列
// fctable/color…色コードまたは色名
// fctable/chk…編集時、指定文字色なら true が入る
// upfile…添付ファイル入力フォームを表示させたいとき true が入る
--> --}}
			@if($post_mode)
			<!--クッキー読込みは新規投稿のみ-->
			@if($regist)
			<script src="loadcookie.js"></script>
			@endif
			<nav>
				<div id="self2">
					[<a href="{{$self2}}">{{$title}}</a>] </div>
			</nav>
		</header>
		@if($admin)
		@if($regist)

		{{-- ペイントフォーム --}}
		@include('parts.paint_form',['admin'=>$admin])

		@endif
		@endif
		<!--投稿待ちのお絵かき画像表示-->
		@if($pictmp)
			@if($notmp)
			<div class="error_mesage">
			找不到圖片。
			<br><a href="#" onclick="javascript:window.history.back(-1);return false;">返回</a>
			</div>
			@endif
			@if($tmp)
			@foreach ($tmp as $tmpimg)
			<div class="posted_img_form"><img src="{{$tmpimg['src']}}" border="0" alt="{{$tmpimg['srcname']}}"></div>
			{{$tmpimg['srcname']}}<br>
			[{{$tmpimg['date']}}]
			@endforeach
			@endif
		@endif
		@if($ptime)
		<div class="centering">
			繪圖時間： {{$ptime}}
		</div>
		@endif
		{{-- 未投稿画像の画像が無い時はフォームを表示しない --}}
		@if(!$notmp)
		<form action="{{$self}}" method="POST" enctype="multipart/form-data" @if(!$rewrite)id="comment_form"@endif>
			<input type="hidden" name="token" value="{{$token}}">
			<!--モード指定:新規投稿-->
			@if($regist)
			<input type="hidden" name="mode" value="regist">
			@endif
			<!--モード指定:編集-->
			@if($rewrite)
			<input type="hidden" name="mode" value="rewrite">

			@if($thread_no)<input type="hidden" name="thread_no" value="{{$thread_no}}">@endif
			@if($logfilename)<input type="hidden" name="logfilename" value="{{$logfilename}}">@endif
			@if($mode_catalog)<input type="hidden" name="mode_catalog" value="{{$mode_catalog}}">@endif
			@if($catalog_pageno)<input type="hidden" name="catalog_pageno" value="{{$catalog_pageno}}">@endif
			@if(!$catalog_pageno)<input type="hidden" name="catalog_pageno" value="0">@endif

			<input type="hidden" name="no" value="{{$rewrite}}">
			<input type="hidden" name="pwd" value="{{$pwd}}">
			@endif
			@if($admin)
			<input type="hidden" name="admin" value="{{$admin}}">
			@endif
			@if($pictmp)
			<input type="hidden" name="pictmp" value="{{$pictmp}}">
			@endif
			@if($ptime)
			<input type="hidden" name="ptime" value="{{$ptime}}">
			@endif
			<!--レスお絵かき対応-->
			@if($resno)
			<input type="hidden" name="resto" value="{{$resno}}">
			@endif
			<input type="hidden" name="MAX_FILE_SIZE" value="{{$maxbyte}}">
			<table id="post_table">
				<tr>
					<td class="post_table_title">名稱 @if($usename) (必需) @endif</td>
					<!--編集時、valueに名前をセット-->
					<td><input type="text" name="name" @if($name) value="{{$name}}" @endif class="post_input_text"
							autocomplete="username"></td>
				</tr>
				<tr>
					<td class="post_table_title">E-mail</td>
					<!--編集時、valueにメールアドレスをセット-->
					<td><input type="text" name="email" @if($email) value="{{$email}}" @endif class="post_input_text"
							autocomplete="email"></td>
				</tr>
				<tr>
					<td class="post_table_title">URL</td>
					<!--編集時、valueにURLをセット-->
					<td><input type="url" name="url" @if($url) value="{{$url}}" @endif class="post_input_text"
							autocomplete="url"></td>
				</tr>
				<tr>
					<td class="post_table_title">標題@if($usesub) (必需) @endif</td>
					<!--編集時、valueに題名をセット-->
					<td><input type="text" name="sub" @if($sub) value="{{$sub}}" @endif class="post_input_text"
							autocomplete="off"></td>
				</tr>
				<tr>
					<td class="post_table_title">內文 @if($usecom) (必需) @endif</td>
					<!--編集時、textarea内に本文をセット-->
					<td><textarea name="com" wrap="soft" class="post_input_com">@if($com){{$com}}@endif</textarea>
					</td>
				</tr>
				<!--ファイルアップロード欄-->
				@if($upfile)
				<tr>
					<td class="post_table_title">附加圖片</td>
					<td><input type="file" name="upfile" accept="image/*">
					</td>
				</tr>
				@endif
				<!--お絵かき画像選択欄-->
				@if($tmp)
				@php 
				rsort($tmp);
				@endphp

				<tr>
					<td class="post_table_title">圖片</td>
					<td><select name="picfile" class="post_select_image">
							@foreach ($tmp as $tmpimg)
							<option value="{{$tmpimg['srcname']}}">{{$tmpimg['srcname']}}</option>
							@endforeach
						</select></td>
				</tr>
				@endif
				<!--新規投稿時は削除キー入力-->
				@if($regist)
				<tr>
					<td class="post_table_title">密碼</td>
					<td><input type="password" name="pwd" value="" class="post_input_pass"
							autocomplete="current-password">
						<span class="howtoedit">(用於編輯和删除文章，請使用英數組合)</span></td>
				</tr> @endif
				<tr>
					<td colspan="2" style="text-align: center;" class="post_table_submit td_noborder"><input
							type="submit" value="送出" class="post_submit"></td>
				</tr>
				<tr>
					<td colspan="2" class="td_noborder">
						<!--新規投稿説明-->
						<ul class="howtowrite">
							@if($regist)
							@if($upfile)
							<li>圖片檔案大小限制為 {{$maxkb}} KB。</li>
							@endif
							@endif
							<!--編集説明-->
							@if($rewrite)
							<li>如果將電子郵件以外的其他項目留空（空白），則內容將保持不變。</li>
							<li>編輯時不保存Cookie。</li>
							@endif
							<!--以下共通-->
						</ul>
					</td>
				</tr>
			</table>
		</form>
		@endif
		<script src="lib/{{$jquery}}"></script>
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
		});
		</script>

		<!--新規投稿のみクッキーを読込み-->
		@if($regist)
		<script>
			document.addEventListener('DOMContentLoaded',l,false);
		</script>
		@endif
		@endif
		<!--投稿モード ここまで-->
		<!--管理モード(認証)-->
		@if($n)
		<!-- 
//
// admin_in…管理モード(認証)のとき true が入る
// home…ホームページURL
// self…POTI-boardのスクリプト名
// self2…入口(TOP)ページのURL
-->
		@endif
		@if($admin_in)
		<div id="self2">
			[<a href="{{$self2}}">{{$title}}</a>]</div>
		</header>
		<form action="{{$self}}" method="post">
			<div class="centering">
				<div class="margin_radio">
					<label class="radio"><input type="radio" name="admin" value="update" checked>更新 HTML </label>
					<label class="radio"><input type="radio" name="admin" value="del">刪除文章 </label>
					<label class="radio"><input type="radio" name="admin" value="post">管理人投稿</label>
				</div>
				<input type="hidden" name="mode" value="admin">
				<input type="password" name="pass" size="8" autocomplete="current-password" class="adminpass">
				<input type="submit" value=" 認証 " class="admin_submit">

			</div>
		</form>
		@endif
		{{-- <!--管理モード(認証) ここまで--> --}}
		{{-- <!--管理モード(削除)--> --}}
		{{-- <!-- 
//
// admin_del…管理モード(削除)のとき true が入る
// home…ホームページURL
// self…POTI-boardのスクリプト名
// self2…入口(TOP)ページのURL
// pass…認証パスワード
// del…削除テーブルグループ
// del/bg…削除テーブルの背景色
// del/no…記事No
// del/now…書込み日付
// del/sub…題名(半角10文字まで)
// del/name…名前(半角10文字まで)
// del/com…本文(半角20文字まで)
// del/host…ホストアドレス
// del/clip…画像へのリンクデータ
// del/size…画像サイズ(Byte)
// del/chk…画像MD5
// all…画像データ合計サイズ(KB)
--> --}}
		@if($admin_del)
		<div id="self2">
			[<a href="{{$self2}}">{{$title}}</a>] </div>
		</header>
		<div class="centering">
			<p>
				選取您要刪除文章的複選框，然後點擊刪除安鈕。<br>
				<span class="hensyu"></span>
			</p>
				<form action="{{$self}}" method="post">
					<input type="hidden" name="admin" value="update">
					<input type="hidden" name="mode" value="admin">
					<input type="hidden" name="pass" value="{{$pass}}">
					<input type="submit" value="更新 HTML" class="admin_submit">
				</form>
				<form id="delete" action="{{$self}}" method="POST">
					<input type="hidden" name="mode" value="admin">
					<input type="hidden" name="admin" value="del">
					<input type="hidden" name="pass" value="{{$pass}}">

					<input type="submit" value="刪除"><input type="reset" value="取消">
					<label class="checkbox"><input type="checkbox" name="onlyimgdel" value="on">僅刪除圖片</label>
				</form>
			<table class="admindel_table">
				<tr class="deltable_tr">
					<th class="nobreak">刪除</th>
					<th class="nobreak">文章 No.</th>
					<th class="nobreak">發表日期</th>
					<th class="nobreak">標題</th>
					<th class="nobreak">投稿者</th>
					<th class="nobreak">內文</th>
					<th class="column_non">主機名稱</th>
					<th class="column_non">附件 (KB)</th>
					<th class="column_non">MD5</th>
				</tr>

				@if($dels)
				@foreach ($dels as $del)

				<tr style="background-color:{{$del['bg']}}">
					<th class="delcheck"><label class="checkbox_nt"><input form="delete" type="checkbox" name="del[]"
								value="{{$del['no']}}"></label></th>

					<th class="nobreak">
						<form action="{{$self}}" method="post" id="form{{$del['no']}}">
							<input type="hidden" name="del[]" value="{{$del['no']}}"><input type="hidden" name="pwd"
								value="{{$pass}}"><input type="hidden" name="mode" value="edit">
							<a href="javascript:form{{$del['no']}}.submit()">{{$del['no']}}</a></form>
					</th>
					<td><small>{{$del['now']}}</small></td>
					<td>{{$del['sub']}}</td>
					<td class="nobreak"><b>{!!$del['name']!!}</b></td>
					<td><small>{{$del['com']}}</small></td>
					<td class="column_non">{{$del['host']}}</td>
					<td class="column_non">@if($del['src'])
						<a href="{{$del['src']}}" target="_blank" rel="noopener" class="luminous">{{$del['srcname']}}</a>
						({{$del['size_kb']}})KB @endif</td>
			<td class="column_non">@if($del['src'])
				{{$del['chk']}}@endif</td>
		</tr>
				@endforeach
				@endif
			</table>
			@if($del_pages)
			@foreach($del_pages as $del_page)
			<div class="del_page">[
				<form action="{{$self}}" method="post" id="form_page{{$del_page['no']}}">
					<input type="hidden" name="mode" value="admin">
					<input type="hidden" name="admin" value="del">
					<input type="hidden" name="pass" value="{{$pass}}">
					<input type="hidden" name="del_pageno" value="{{$del_page['no']}}">
					@if($del_page['notlink'])
					<strong>{{$del_page['pageno']}}
					</strong>
				</form>
			@else
			<a href="javascript:form_page{{$del_page['no']}}.submit()">{{$del_page['pageno']}}</a></form>
			@endif
			]</div>

			@endforeach
			@endif
			<p>【 圖片檔案合計 : <b>{{$all}}</b> KB 】</p>
		</div>
		@endif
		<!--管理モード(削除) ここまで-->
		<!--エラー画面-->
		{{-- //
		// err_mode…エラー画面のとき true が入る
		// home…ホームページURL
		// self…POTI-boardのスクリプト名
		// self2…入口(TOP)ページのURL
		// mes…エラーメッセージ --}}
		@if($err_mode)

		<div id="self2">
			[<a href="{{$self2}}">{{$title}}</a>] </div>
		</header>
		<div class="error_mesage">
			{!!$mes!!}
			<br><a href="#" onclick="javascript:window.history.back(-1);return false;">返回</a>
		</div>

		@endif
		<!--エラー画面 ここまで-->
		<footer>
			<!--著作権表示 削除しないでください-->
			@include('parts.copyright')
		</footer>
	</div>
	<div id="page_top"><a class="icon-angles-up-solid"></a></div>
	<script src="lib/{{$jquery}}"></script>
	<script src="lib/luminous/luminous.min.js"></script>
	<script src="{{$skindir}}js/basic_common.js"></script>
</body>
</html>