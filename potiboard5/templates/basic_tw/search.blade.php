<!DOCTYPE html>
<html lang="zh-Hant-TW">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link rel="preload" as="style" href="{{$skindir}}icomoon/style.css" onload="this.rel='stylesheet'">
	<link rel="preload" as="script" href="lib/{{$jquery}}">
	<link rel="stylesheet" href="{{$skindir}}search.css">
	<style>
		img {
			height: auto;
		}
	</style>
	@if (!$imgsearch)
	<style>
		.article {
			white-space: nowrap;
			overflow: hidden;
			text-overflow: ellipsis;
			padding: 3px 0;
			border-bottom: 1px dashed #8a8a8a;
			line-height: 3em;
		}

		img {
			max-width: 300px;
			margin: 12px 0 0;
		}
	</style>
	@endif
	<title>{{$title}}{{$pageno}}</title>
</head>

<body>
	<div id="main">
		<header>
			<div class="title">
				<h1>{{$h1}}<span class="title_wrap">{{$pageno}}</span></h1>
			</div>
		</header>
		<nav>
			<div class="menu">
				[<a href="./@if($php_self2){{$php_self2}} @endif">返回留言板</a>]
				@if($imgsearch)
				[<a href="?page=1&imgsearch=off{{$query_l}}">留言</a>]
				@else
				[<a href="?page=1&imgsearch=on{{$query_l}}">插圖</a>]
				@endif


			</div>
		</nav>
		<!-- 反復 -->
		@if ($comments)
		@if ($imgsearch)
		<div class="newimg">
			<ul>@foreach ($comments as $comment)<li class="catalog"><a href="{{$comment['link']}}" target="_blank"><img
							src="{{$comment['img']}}"
							alt="「{{$comment['sub']}}」插圖/{{$comment['name']}}{{$comment['postedtime']}}"
							title="「{{$comment['sub']}}」by {{$comment['name']}} {{$comment['postedtime']}}"
							loading="lazy" width="{{$comment['w']}}" height="{{$comment['h']}}"></a></li>@endforeach</ul>
		</div>
		@else
		@foreach ($comments as $comment)
		<article>
			<div class="article">
				<div class="comments_title_wrap">
					<h2><a href="{{$comment['link']}}" target="_blank">{{$comment['sub']}}</a></h2>
					{{$comment['postedtime']}}<br><span class="name"><a
							href="?page=1&query={{$comment['encoded_name']}}&radio=2"
							target="_blank">{{$comment['name']}}</a></span>
				</div>
				@if ($comment['img'])
				<a href="{{$comment['link']}}" target="_blank"><img src="{{$comment['img']}}"
						alt="{{$comment['sub']}} by {{$comment['name']}}" loading="lazy" width="{{$comment['w']}}" height="{{$comment['h']}}"></a><br>
				@endif
				{{$comment['com']}}
				<div class="res_button_wrap">
					<form action="{{$comment['link']}}" method="post" target="_blank"><input type="submit" value="回覆"
							class="res_button"></form><span class="page_top"><a href="#top">△</a></span>
				</div>
			</div>
		</article>
		@endforeach
		@endif
		@endif
		<p></p>

		<p>從留言板按照新帖子的順序調用{{$img_or_com}}。</p>
		<!-- 最終更新日時 -->
		@if($lastmodified)
		<p>last modified: {{$lastmodified}}</p>
		@endif

		<p></p>
		<form method="get" action="./search.php">
			<span class="radio">
				<input type="radio" name="radio" id="author" value="1" @if($radio_chk1)checked="checked"@endif><label for="author"
					class="label">名稱</label>
				<input type="radio" name="radio" id="exact" value="2" @if($radio_chk2)checked="checked"@endif><label for="exact"
					class="label">完全一致</label>
				<input type="radio" name="radio" id="fulltext" value="3" @if($radio_chk3)checked="checked"@endif><label for="fulltext"
					class="label">表題留言</label>
			</span>
			<br>
			@if ($imgsearch)
			<input type="hidden" name="imgsearch" value="on">
			@else
			<input type="hidden" name="imgsearch" value="off">
			@endif
			<input type="text" name="query" placeholder="搜尋" value="{{$query}}">
			<input type="submit" value="搜尋" />
		</form>
		<p></p>

		<footer>
			<nav>
				<div class="leftbox">
					<!-- ページング -->
					{!!$prev!!}@if($nxet) | {!!$nxet!!} @endif
				</div>
				<!-- 著作表示 消さないでください -->
				<div class="rightbox">- <a href="https://paintbbs.sakura.ne.jp/poti/"
						target="_blank">search</a> -</div>
				<div class="clear"></div>
			</nav>
		</footer>

	</div>
	<div id="bottom"></div>
	<div id="page_top"><a class="icon-angles-up-solid"></a></div>
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
</body>

</html>