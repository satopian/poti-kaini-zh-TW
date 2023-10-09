<!DOCTYPE html>
<!-- mocked drawing page -->
<html lang="zh-Hant-TW">
<head>
	<meta charset="UTF-8">
	<title>繪圖模式 - {{$title}}</title> 
	<!-- this is important -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">

	<style>
		:not(input){
		-moz-user-select: none;
		-webkit-user-select: none;
		-ms-user-select: none;
		user-select: none;
		}
	</style>
</head>
<body>

<!-- embed start -->
<script src="klecks/embed.js?{{$parameter_day}}&{{$ver}}"></script>
<script>
	/*
	Using Klecks in a drawing community:
	- on first time opening, start with a manually created project (klecks.openProject)
	- on submit, upload psd (and png) to the server
	- on continuing a drawing, read psd that was stored on server (klecks.readPsd -> klecks.openProject)
		*/

	const psdURL = '@if($img_klecks){{$img_klecks}}@endif';

	let saveData = (function () {
		let a = document.createElement("a");
		document.body.appendChild(a);
		a.style = "display: none";
		return function (blob, fileName) {
			let url = window.URL.createObjectURL(blob);
			console.log(url);
			a.href = url;
			a.download = fileName;
			a.click();
			window.URL.revokeObjectURL(url);
		};
		
	}());

	const klecks = new Klecks({
		
		disableAutoFit: true,
		
		onSubmit: (onSuccess, onError) => {
			// download png
			// saveData(klecks.getPNG(), 'drawing.png');

			/*// download psd
			klecks.getPSD().then((blob) => {
				saveData(blob, 'drawing.psd');
			});*/

			setTimeout(() => {
			onSuccess();
			//2022-2023 (c)satopian MIT Licence
			//この箇所はさとぴあが作成したMIT Licenceのコードです。
				const postData = (path, data) => {
					fetch(path, {
						method: 'post',
						mode: 'same-origin',
						headers: {
							'X-Requested-With': 'klecks'
							,
						},
						body: data,
					})
					.then((response) => {
						if (response.ok) {
							response.text().then((text) => {
							console.log(text)
							if(text==='ok'){
								return window.location.href="?mode={!!$mode!!}&stime={{$stime}}";
							}
								return alert(text);
							})
						}else{
							let response_status = response.status; 

							if(response_status===403){
								return alert(@if($en)'It may be a WAF false positive.\nTry to draw a little more.'@else'投稿に失敗。\nWAFの誤検知かもしれません。\nもう少し描いてみてください。'@endif);
							}
							if(response_status===404){
								return alert(@if($en)'404 not found\nsaveklecks.php'@else'エラー404\nsaveklecks.phpがありません。'@endif);	
							}
							return alert(@if($en)'Your picture upload failed!\nPlease try again!'@else'投稿に失敗\n時間をおいて再度投稿してみてください。'@endif);
						}
					})
					.catch((error) => {
						return alert(@if($en)'Server or line is unstable.\nPlease try again!'@else'サーバまたは回線が不安定です。\n時間をおいて再度投稿してみてください。'@endif);	
					})
				}
				klecks.getPSD().then((psd)=>{
					var formData = new FormData();
					formData.append("picture", klecks.getPNG(),'blob');
					formData.append("psd", psd,'blob');
					formData.append("usercode", "{{$klecksusercode}}");
					@if($rep)formData.append("repcode", "{{$repcode}}");@endif
					formData.append("stime", <?=time();?>);
					formData.append("resto", "{{$resto}}");
					formData.append("tool", "Klecks");
					postData("?mode=saveimage&tool=klecks", formData);
				});
				// (c)satopian MIT Licence ここまで
				// location.reload();
			}, 500);
		}
	});
	if (psdURL) {
		fetch(new Request(psdURL)).then(response => {
			return response.arrayBuffer();
		}).then(buffer => {
			return klecks.readPSD(buffer); // resolves to Klecks project
		}).then(project => {
			klecks.openProject(project);
		}).catch(e => {
			klecks.initError(@if($en)'failed to read image'@else'画像の読み込みに失敗しました。'@endif);
		});

	} else {

		klecks.openProject({
			width: {{$picw}},
			height: {{$pich}},

			layers: [{
				name: 'Background',
				opacity: 1,
				mixModeStr: 'source-over',

				image: (() => {
					const canvas = document.createElement('canvas');
					canvas.width = {{$picw}};
					canvas.height = {{$pich}};
					const ctx = canvas.getContext('2d');
					//PSDがなくて画像がある時はcanvasに読み込む
					@if($imgfile)
						var img = new Image();
						img.src = "{{$imgfile}}";
						img.onload = function(){
							ctx.drawImage(img, 0, 0);
						}
					@endif
					ctx.save();
					ctx.fillStyle = '#fff';
					ctx.fillRect(0, 0, canvas.width, canvas.height);
					ctx.restore();
					return canvas;
				})(),
			},{
				name: '{{$TranslatedLayerName}} 1',
				opacity: 1,
				mixModeStr: 'source-over',
				image: (() => {
					const canvas = document.createElement('canvas');
					canvas.width = {{$picw}};
					canvas.height = {{$pich}};
					return canvas;
				})()
			}
		]});
	}
</script>
<!-- embed end -->
</body>
</html>
