# 繪圖留言板 PHP script POTI-board EVO 的中文翻譯本
## 這是POTI-board EVO 的繁體中文翻譯本.
This is the traditional Chinese translation version of POTI-board EVO.  
這是日語顯示的原文.  
[satopian/poti-kaini: ｢お絵かき掲示板PHPスクリプトPOTI-board EVO｣ for PaintBBS NEO and ChickenPaint, (PHP5.5～7.x , 8.0)](https://github.com/satopian/poti-kaini)
存儲庫管理員依靠Google翻譯，因為它只懂日語.  

###
[繪圖留言板](https://paintbbs.sakura.ne.jp/cgi/neosample/poti-board-zh-TW/index.html)(繁體中文)

## Serious bugs in older versions
- POTI-board v2.26.0 and earlier all versions is vulnerable to XSS.    
Malicious JavaScript can be executed.

- All versions of POTI-board prior to v3.09.5 have a serious bug.    
You may lose all log files.

Please update to v3.10.1 or higher.
  
###
  
![image](https://user-images.githubusercontent.com/44894014/117331996-480b5700-aed2-11eb-8580-297e4c6268e5.png)  

### Overview of required work.
There is a language resource for messages in `template_ini.php`, such as error messages and messages used when images are uploaded successfully.  
The HTML of the template uses Japanese, so we need to translate it.  
We also need to translate the external search programs `search.php` and `search.html`.    
However, potiboard.php externalizes all language settings, so no changes are needed.  
Translation of `config.php`. We need to translate the description of the settings.    

## [2022/01/27] v5.01.03
### Change to BladeOne for template engine

I changed the template engine to BladeOne because I get a deprecated error from Skinny.php in PHP8.1 environment.
However, that means that the templates will be incompatible.
Templates with the extension `HTML` have been replaced with templates with the extension `blade.php`.
When you open the content, it's not much different from a traditional template. However, it may seem difficult because the extension is not HTML. 

### What has changed due to the change of the template engine
#### PHP7.1
- I was developing it to work in PHP5.6 environment, but I found that v4.2 of BladeOne only works in PHP7.1 or higher environment.
POTI-board EVO v5.x requires PHP 7.1 or higher.

#### Information for those who customize and use templates.
The thread display process has changed significantly.
Previously, there was processing for the parent of the thread, and there was separate processing for reply.

In v5.x, the loop of the array of one thread is ended at once.

It then treats the first loop as the parent of the thread.
Specifically, it looks like the following.

```
	@foreach ($ress as $res)
	 {{-- Parent article header -}}
	@if ($loop->first)
	{{-- First loop -}}
	<h2 class="article_title"><a href="{{$self}}?res={{$ress[0]['no']}}">[{{$ress[0]['no']}}]
			{{$ress[0]['sub']}}</a></h2>

	@else
	<hr>
	{{-- article header for reply -}}
	<div class="res_article_wrap">
		<div class="res_article_title">[{{$res['no']}}] {{$res['sub']}}</div>
		@endif

```

`@if ($loop->first)` is true for the first loop of the thread.
When `@if ($loop->first)` is true, it is processed as the parent of the thread.
The `<h2>` tag of the title that is displayed differently only when it is the parent of the thread is put in that place.

If you install the extension [laravel-blade](https://marketplace.visualstudio.com/items?itemName=cjhowe7.laravel-blade&ssr=false#review-details) in a free editor called VScode, the editor screen will appear. Switch to a color scheme optimized for the blade syntax.
Both the extension and the editor itself can be used free of charge.
### Files that have changed
all.
## Looking ahead for a few years
We apologize for the incompatibility of the template and the resetting of config.php, but we hope you understand it.

Also, please use the PHP script for the Oekaki bulletin board called [Petit Note](https://github.com/satopian/Petit_Note), which was newly recreated from scratch.

More information can be found in the release.    
[Release POTI-board EVO zh-TW 5.01.03 released.](https://github.com/satopian/poti-kaini-zh-TW/releases/tag/v5.01.03)

## [2021/12/22] v3.19.5

- Added the ability to display images of the next and previous threads in the reply view.  
  
- When you continue from the Reply image with a "new post", that image becomes the Reply image.  
Previously, if you continue and draw from the image of Reply, a new thread was created.  

- After replying, the screen of each thread that replied is now displayed.
Previously, the top page was displayed regardless of where you replied to the thread.
- The display method when editing / deleting in reply mode or catalog mode to complete the work has been changed.  
For example, if you edit / delete on the second page of catalog mode, the second page of catalog mode will be displayed.  
Until now, the top page was displayed.  
- Individual threads are now displayed when you continue drawing and the post is complete.
Until now, the top page was displayed.
If the image you want to continue is many pages away from the top page, you had to find the image from many pages.

- ChickenPaint Swipe a specific part of the screen to prevent it from moving up or down. The relevant parts are controlled by JavaScript.  
  
More information can be found in the release.    
[Release POTI-board EVO zh-TW v3.19.5 released.](https://github.com/satopian/poti-kaini-zh-TW/releases/tag/v3.19.5)


## [2021/12/04] v3.15.3

- Updated index.php required for new installations.  
Even if the PHP version is PHP5.3 or lower, an error message will be displayed indicating that it will not work because the PHP version is low.  
Previously it was a fatal PHP error.  

- Fixed an issue where long press the ChickenPaint's palette with the pen would open an unwanted mouse right-click menu.

- Fixed an issue where the screen would move up and down when copying and layer merging with PaintBBS NEO.  
If you select a rectangle to perform a copy and layer combination operation, the pen may protrude slightly from the canvas.  
At this time, the PaintBBS NEO's canvas may move up and down.  
Occurs when using Windows ink or Apple Pencil.  
If a screen width wider than the iPad is detected, the screen will not move even if you swipe the mesh part around the canvas of PaintBBSNEO.  
When using a smartphone, the operation is the same as before. Because if you want to pinch out the canvas and zoom in,If you cannot swipe, you cannot operate.   

Please update `pink_paint.html` to resolve these issues.

- picpost.php
Fixed false positives for languages.

More information can be found in the release.  

[Release POTI-board EVO zh-TW v3.15.3 released.](https://github.com/satopian/poti-kaini-zh-TW/releases/tag/v3.15.3)

## [2021/11/23] v3.15.2
### Updated contents of `potiboard.php`

- Chi file deletion process after upload painting
I added it because there was no process to delete the chi file after uploading the ChickenPaint-specific file and the chi format file and loading it on the canvas in the administrator's post.
This fix removes it from the temporary directory 5 minutes after uploading. Prior to this fix, files that were no longer needed were deleted after a few days.
- The HTML ALT for images has been fixed. The HTML translation of the theme has been improved.

## [2021/11/08] v3.12.2

### `potiboard.php` updates

- Fixed the calculation method of the width and height of the thumbnail image and the width and height of the HTML image when drawing the continuation.
The setting value of connfig.php is set as the maximum value and the calculation is restarted from the beginning.
In ChickenPaint, you can change the height and width of the image by rotating it, but until now, the size of the thumbnail image became smaller each time it was rotated.
- The actual canvas size is now set in the cookie. Previously, the value entered by the user was set as is. Since there is a maximum value for the canvas size, for example, when the maximum is 800px, even if you enter 8000px, the actual canvas size that opens is 800px.
Previously, the cookie was set to 8000px even in such cases.
- An error is now returned when a file name with an invalid length is entered.
- Checks the length of the reply number and returns an error if the length is incorrect.
- Fixed the specification that the full text of the parent's comment is displayed in the description of the article displayed on the reply screen, and now omits 300 bytes or more.

Please update `potiboard.php`.
### `picpost.php` and `save.php` updates
- In order to mitigate unauthorized posting from external sites, the usercode set in the usercode and cookie during post processing is now checked.

Please update `picpost.php` and `save.php`.

More information can be found in the release.  

[Release POTI-board EVO zh-TW v3.12.2 released.](https://github.com/satopian/poti-kaini-zh-TW/releases/tag/v3.12.2)


## [2021/10/31] v3.10.1 
- Added password length check. 
- Moved the length check of each input item to the first half of the process.

Fixed a minor error that occurred when displaying the management screen.
The file needed to fix this issue is potiboard.php.
Please update `potiboard.php` by overwriting.


## [2021/10/30] v3.10.0 Fixed a serious bug

- All versions of POTI-board prior to v3.09.5 have a serious bug.
You may lose all log files.

For those who are using POTI-board v2.  
You cannot use all the functions of v3 system just by replacing `potiboard.php`, but you can deal with this problem.  

Please update `potiboard.php` by overwriting.


### [2021/10/27] v3.09.5

- To prevent the use of weak passwords, an error message will be displayed when the password is 5 characters or less. The error message is "Password is too short. At least 6 characters."
- In order to prevent tampering with articles by third parties, the function to lock replies to threads older than the set number of days has been expanded to lock editing of old articles.
You can delete it. In addition, the administrator can edit and delete as before.

- If you used the old config.php that doesn't have the following settings, you had to check or uncheck [no_imane].  
>// Use to the checkbox of [no_imane], do:'1', do not:'0'  
define('USE_CHECK_NO_FILE', '0');  

we changed this default value from "do:'1'" to "do not:'0'".  
Previously, even if you were using a new theme HTML file, you had to check or uncheck "[no_imane]" when the version of config.php was old.  
- Changing the copyright link on the site. [https://paintbbs.sakura.ne.jp/poti/](https://paintbbs.sakura.ne.jp/poti/)

### [2021/09/28] v3.08.1
#### bug fixes
- Fixed an issue where the submit button was not enabled when using the browser's "History Back" or error screen "Back" links.  
More information can be found in the release.  
[Release POTI-board EVO zh-TW v3.08.1](https://github.com/satopian/poti-kaini-zh-TW/releases/tag/v3.08.1)


### [2021/09/28] v3.07.5

#### Minor bug fixes
 - Fixed the problem that the Paint BBS menu was displayed strangely when the browser language was other than Japanese.

 - Fixed the processing specification that determines whether to start the drawing time calculation.
 - Even if an error occurs during the posting process, you can repost the drawing image from the unposted image. Moved work file deletion to almost the end of the post process. Previously, if an error occurred in the second half of the posting process, the posted illustration would remain on the server but could not be displayed on the bulletin board.

#### Improved auto-complete for Chrome and Firefox

When editing or deleting an article, if you enter the article number and press the edit button, the password may be saved as a set with the user name as the article number.


To avoid this problem, I created a separate input field hidden by CSS.
This makes it easier to save passwords that use your name as your username.

More information can be found in the release.  
[Release POTI-board EVO v3.07.5 released · satopian/poti-kaini-zh-TW](https://github.com/satopian/poti-kaini-zh-TW/releases/tag/v3.07.5)

### [2021/08/11] v3.05.3 lot.210811
- Added decoding process because Tweet and notification emails are HTML-escaped garbled characters.
- Added output variables corresponding to the title and name used for Tweet.
#### Information for theme authors
`<% def(oya/share_sub)><% echo(oya/share_sub) %><% else %><% echo(oya/sub|urlencode) %><% /def %>`    
`<% def(oya/share_name)><% echo(oya/share_name) %><% else %><% echo(oya/name|urlencode) %><% /def %>`  
If the version of the POTI board itself is low and the newly added variables are undefined, use the variables for the old Tweet.  
When a newly added variable is defined.  
Use a new variable.  
### [2021/08/22] v3.06.8 lot.210822

- The chickenpaint icon has been updated

- Fix garbled characters  
Fixed the problem that the character string posted on the Twitter screen when the Tweet button was pressed was garbled.  
Fixed garbled characters in post notification emails.  
- Administrator deletion screen  
Improved security. Strengthened XSS measures.  
Changed the number of items displayed on one page from 2000 to 1000.
- Fixed error message  
"chi" has been added to the description of supported formats because you can use "chi" files for the ability to upload files and load them onto the canvas.

2021/08/23 Due to my mistake, there was no new icon for chicken paint.  
I apologize for any inconvenience, but please overwrite and update the ChickenPaint directory.
It has been fixed in (v3.06.8.1).
  
More information can be found in the release.  
[Release POTI-board EVO zh-TW v3.06.8.1](https://github.com/satopian/poti-kaini-zh-TW/releases/tag/v3.06.8.1)

### [2021/08/06] v3.05.2.2
- ChickenPaint has been updated to fix many iOS related bugs. Bugs related to palm rejection have been resolved.  
You can now recognize your palm and Apple Pencil. Until now, unintended straight lines have occurred.  

More information can be found in the release.  
[Release POTI-board EVO zh-TW v3.05.2.2](https://github.com/satopian/poti-kaini-zh-TW/releases/tag/v3.05.2.2)

### [2021/08/03] v3.05.2 lot.210803
- Resolved an issue where using ChickenPaint on an iPad would cause unintended double-tap zoom issues that would make drawing difficult.  
Please update the HTML for Paint screen.
- `<img loading = "lazy"> `. Added `loading =" lazy "` to the `img` tag of theme.


### [2021/07/18] v3.05.1 lot.210616
- CSRF measures using fixed tokens have been introduced. You can reject unauthorized posts from outside the site.  
If the theme HTML does not support tokens  
`define('CHECK_CSRF_TOKEN', '1');`  
To
Change to   
`define('CHECK_CSRF_TOKEN', '0');`.
If you enable this setting when the theme is not supported, you will not be able to post.
If this setting is not present in `config.php`  
`define('CHECK_CSRF_TOKEN', '0');`  
Is treated the same as.
- Moved to the method of checking HTML at the time of output.  
Administrators can no longer use HTML tags.  
HTML tags that have already been entered will be deleted.  
The output is the HTML tags removed and escaped.  
- The form on the top page and the mini-less form displayed in each thread have been abolished.  
This is because you cannot set the CSRF token in a static HTML file.  
- ChickenPaint is now available on your smartphone.  

More information can be found in the release.  
[Release POTI-board EVO zh-TW v3.05.1](https://github.com/satopian/poti-kaini-zh-TW/releases/tag/v3.05.1)


### [2021/08/03] v3.05.2 lot.210803
- Resolved an issue where using ChickenPaint on an iPad would cause unintended double-tap zoom issues that would make drawing difficult.  
Please update the HTML for Paint screen.
- `<img loading = "lazy"> `. Added `loading =" lazy "` to the `img` tag of theme.

### [2021/06/17] v3.02.0 lot.210617
- Addressed an issue where the Chicken Paint screen would be selected.
- Prevents returning to the previous screen with Windows ink and two-finger gestures when drawing with PaintBBS NEO and shi-Painter.

### [2021/06/05] v3.01.9 lot.210605
- Updated to the latest version of "ChickenPaint".  
If the browser language is other than Japanese, it will be displayed in English. If the browser language is Japanese, it will be displayed in Japanese.
- Management screen paging Page breaks in units of 2000.  
Improved paging on the main page and catalog page.  
Shifted to a method of paging in 35-page units.  

- Addressed the version of CheerpJ where the "shi-painter" does not start.  
The JavaScript url required to start CheerpJ is managed in potiboard.php.  

### [2021/05/15]v.3.00.1
- In v3.0, the HTML5 version of the high-performance paint application [ChickenPaint](https://github.com/thenickdude/chickenpaint) is available.  
The HTML5 version of [PaintBBS NEO](https://github.com/funige/neo/) is still available.  
### [2021/05/08]  
- Update config.php translation  by Minchao.
### [2021/05/07]  
- Update config.php translation.
### [2021/05/03]  
- Update palette.txt translation by Minchao.
### [2021/05/01]  
- Update the pink_paint translation by Minchao.
### [2021/04/30]  
- Update the pink templates translation by Minchao.
- translation search.php and search.html by satopian (It may be wrong because it is translated by groping.) 
- Improved translation of error messages.But this is still not enough.
### [2021/04/29]  
- I translated `config.php` except for the detailed settings. I took care not to change the meaning, but I need to replace it with an appropriate translation.   
- Advanced settings are not translated.

### [2021/04/28]  
開始翻譯. 
Translated the const in template_ini.php.  
Some translations remain in English or Japanese.  
This is because the translation of that part did not go well.  
I would like help from those who understand Chinese.  
- template_ini.php 
- I translated template_ini.php.  
This is an incomplete translation.  
Please pull request and fix this.  

