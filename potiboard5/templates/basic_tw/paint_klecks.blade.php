<!DOCTYPE html>
<!-- mocked drawing page -->
<html lang="zh-Hant-TW">
<head>
    <meta charset="UTF-8">
	<title>繪圖模式 - {{$title}}</title> 

    <!-- this is important -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<style>
		body {
		letter-spacing: initial;
		word-break:initial;
		}
		li{margin:inherit;}
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
<script src="klecks/embed.js?{{$parameter_day}}"></script>
<script type="text/javascript">

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
		
        onSubmit: (onSuccess, onError) => {
            // download png
            // saveData(klecks.getPNG(), 'drawing.png');

           /*// download psd
            klecks.getPSD().then((blob) => {
                saveData(blob, 'drawing.psd');
            });*/

            setTimeout(() => {
                onSuccess();

			//2022 (c)satopian MIT LICENCE
			//この箇所はさとぴあが作成したMIT LICENCEのコードです。
			klecks.getPSD().then((psd)=>{
				var formData = new FormData();
				formData.append("picture", klecks.getPNG(),'blob');
				formData.append("psd", psd,'blob');
				formData.append("usercode", "{{$klecksusercode}}");
				@if($rep)formData.append("repcode", "{{$repcode}}");@endif
				formData.append("stime", <?=time();?>);
				formData.append("resto", "{{$resto}}");

				var request = new XMLHttpRequest();
				request.open("POST", "saveklecks.php");
				request.send(formData);

					request.onreadystatechange = function() {

					console.log(request.readyState);
					console.log(request.responseText);

					if ( request.readyState === 4 && request.status ===200) {

						if(request.responseText === 'ok'){
						//PHPからOKが返って来た時は画面を推移。OKが返って来ない時は、alertを出す。
						return window.location.href="?mode={!!$mode!!}&stime={{$stime}}";
						
					}
					alert(@if($en)'Your picture upload failed! Please try again!'@else'投稿に失敗。時間をおいて再度投稿してみてください。'@endif);
					return;
				}
			}
		});
		//2022 (c)satopian MIT LICENCE ここまで
			
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
            klecks.initError('failed to read image');
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
        }]
    });
}
</script>
<!-- embed end -->

</body>
</html>