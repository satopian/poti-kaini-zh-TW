{{-- メイン時ページング表示 --}}
<div id="paging_wrap">@if($firstpage)<span class="parentheses"><a href="{{$firstpage}}">第一個</a> |</span>@endif{!!$paging!!}@if($lastpage)<span class="parentheses"> | <a href="{{$lastpage}}">最後</a></span>@endif</div>

{{-- メインとカタログのページング --}}
<nav>
	<div class="pagelink">
	<div class="pagelink_prev">@if ($prev)<a href="{{$prev}}">≪上一頁</a>@endif
	</div>
	<div class="pagelink_top"><a href="{{$self2}}">留言板頂部</a></div>
	<div class="pagelink_next">@if ($next)<a href="{{$next}}">下一頁≫</a>@endif</div>
	</div>
</nav>
	