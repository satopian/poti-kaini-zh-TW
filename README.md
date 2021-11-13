# 繪圖留言板 PHP script POTI-board EVO 的中文翻譯本
## 這是POTI-board EVO 的繁體中文翻譯本.
This is the traditional Chinese translation version of POTI-board EVO.  
這是日語顯示的原文.  
[satopian/poti-kaini: ｢お絵かき掲示板PHPスクリプトPOTI-board EVO｣ for PaintBBS NEO and ChickenPaint, (PHP5.5～7.x , 8.0)](https://github.com/satopian/poti-kaini)
存儲庫管理員依靠Google翻譯，因為它只懂日語.  

###
[繪圖留言板](https://paintbbs.sakura.ne.jp/cgi/neosample/poti-board-zh-TW/index.html)(繁體中文)

## Serious bugs in older versions
- POTI-board prior to v2.26.0 is vulnerable to XSS.  
Malicious JavaScript can be executed.

- All versions of POTI-board prior to v3.09.5 have a serious bug.    
You may lose all log files.

Please update `potiboard.php` with v3.10.1 or later by overwriting.
For those who are using the old version v2.x system.
Please update `potiboard.php` by overwriting. Overwriting updates to `potiboard.php` alone can address the above two major issues.
  
###
  
![image](https://user-images.githubusercontent.com/44894014/117331996-480b5700-aed2-11eb-8580-297e4c6268e5.png)  

### Overview of required work.
There is a language resource for messages in `template_ini.php`, such as error messages and messages used when images are uploaded successfully.  
The HTML of the template uses Japanese, so we need to translate it.  
We also need to translate the external search programs `search.php` and `search.html`.    
However, potiboard.php externalizes all language settings, so no changes are needed.  
Translation of `config.php`. We need to translate the description of the settings.    

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

