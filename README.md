# 繪圖留言板 PHP script POTI-board EVO 的中文翻譯本
## 這是POTI-board EVO 的繁體中文翻譯本.
This is the traditional Chinese translation version of POTI-board EVO.  
這是日語顯示的原文.  
[satopian/poti-kaini: ｢お絵かき掲示板PHPスクリプトPOTI-board EVO｣ for PaintBBS NEO and ChickenPaint](https://github.com/satopian/poti-kaini)
存儲庫管理員依靠Google翻譯，因為它只懂日語.  

 
![image](https://user-images.githubusercontent.com/44894014/184851937-4dadefac-a987-4c10-a47c-812b3e720dc6.png)

### [繪圖留言板](https://paintbbs.sakura.ne.jp/cgi/neosample/poti-board-zh-TW/index.html)(繁體中文)

## Serious bugs in older versions
- POTI-board v2.26.0 and earlier all versions is vulnerable to XSS.    
Malicious JavaScript can be executed.

- All versions of POTI-board prior to v3.09.5 have a serious bug.    
You may lose all log files.

- POTI-board v3.x gives a deprecated error in PHP8.1 It will not work with future versions of PHP.

Please update to v5.x or higher.

### Overview of required work.
There is a language resource for messages in `template_ini.php`, such as error messages and messages used when images are uploaded successfully.  
The HTML of the template uses Japanese, so we need to translate it.  
We also need to translate the external search programs `search.php` and `search.html`.    
However, potiboard.php externalizes all language settings, so no changes are needed.  
Translation of `config.php`. We need to translate the description of the settings.    

## 2024/11/03 v6.39.8
### ChickenPaint Be has been updated
- Fixed an issue where the ChickenPaint Be texture palette could not be scrolled.  
(Scrolling the texture palette is necessary on devices with small screens such as smartphones.)  


## 2024/11/03 v6.39.7
### Classify the series of GD processes for thumbnail creation to make the source code more readable
- As a result of cramming functions into `thumbnail_gd.php`, the readability of the source code significantly decreased, so we reorganized it into a static class.  
`thumbnail_gd.php` has been deleted.  
Use `thumbnail_gd.inc.php` instead.  
`thumbnail_gd.php` is no longer necessary, but there is no problem if it remains on the server.  
Please be careful when deleting, as you may delete a necessary file when trying to delete an unnecessary file.
thumbnail_gd.inc.php` is now a common class with [Petit Note](https://github.com/satopian/Petit_Note).  
There is no longer a need to maintain two types of files, one for Petit Note and one for POTI-board.  
### Fixed a bug that reduced the actual size of drawing images.
```
// The maximum size for width and height during upload, any larger will be resized.  
define("MAX_W_PX", "1024"); //Width  
define("MAX_H_PX", "1024"); //Height  
```
Fixed a bug that reduced the image size when the size set with `MAX_W_PX` or `MAX_H_PX` was smaller than the maximum size that can be drawn.  
The image size limit for drawing images should have been specified as the maximum size that can be drawn, and it was unintended that the image would become smaller than the initial image after posting.  

### When posting, the screen now scrolls to the posted reply
- Because there is an input field at the top, previously the top of the reply screen was displayed once posting was completed.  
However, this could make it difficult to tell if the reply comment was posted, so we've made it so that the screen scrolls to a position where the reply comment is visible.  

## 2024/11/01 v6.39.3
- I have improved the function to convert PNG images to JPEG when they exceed MAX_KB, and moved the GD processing that was processed in potiboard.php to thumbnail_gd.php.  
By utilizing the existing GD processing, the code in potiboard.php has been shortened.  

- When drawing, even if the image file size exceeds the value specified in MAX_KB, the post will be completed without an error.  
As before, images attached from the posting form will result in an error when they exceed MAX_KB.  
This specification has existed until now, but even if the original file size is very large, it will be reduced due to the vertical and horizontal limitations, and if the file size is larger than MAX_KB, PNG will be converted to JPEG, and if the final file size is within the MAX_KB range, the post will be successful.  

## 2024/10/26 v6.38.1
### ChickenPaint Be has been updated.
#### You can now change the brush size by dragging the circle in the brush preview screen with the pen

![2024-10-26-Brush Palette](https://github.com/user-attachments/assets/aa5747a9-6102-45fd-8fcd-05139e8894b4)  

- The process that was optimized for the mouse has been rewritten as PointerEvent so that it can be operated with the pen.  
In addition, to prevent malfunctions, the default behavior of touchmoveEvent for each palette and the main menu has been canceled.  
Fixed an issue where a dragged object would continue to move even if the pen was removed from the screen.  


## 2024/10/25 v6.38.0
### ChickenPaint Be has been updated.
#### Added noise texture to texture palette
![Image](https://github.com/user-attachments/assets/7799d25c-2783-44a5-bae0-9185a3c628b2)
- Added "Noise Texture" to "Texture Palette".
Previously, you could add noise by using the "Monochrome Noise" option in the Effects menu in combination with layer effects, but the addition of "Noise Texture" allows you to create a slightly different type of noise.  
By using it in combination with a pen or pencil, you can draw more pencil-like lines.  
It is also effective when applying thick paint with a watercolor brush.  

#### Disable texture when using eraser

- Added a process to disable texture when using eraser.  
You can now erase with the eraser even if a texture is selected.  
Previously, if you selected a texture and used the eraser, you could not erase it completely.  
- Textures are applied when using the soft eraser. Please use the soft eraser when creating patterns by combining textures with the eraser.

## 2024/10/23 v6.37.8
### Search code optimization
- To improve code readability, the same process was made into a function.
By making it a function, 16 lines that repeated the same process were reduced to 4 lines.  
### ChickenPaint Be updated
- Bootstrap is no longer declared globally, but is imported where necessary.  
In addition, processes that can be reduced were deleted.  
The build date is now listed in "About ChickenPaint Be".  
This makes it possible to see at a glance when ChickenPaint Be was built.  

![image](https://github.com/user-attachments/assets/79592935-e77b-4907-a4e3-05dc8dbe663a)


## 2024/10/15 v6.37.7
### ChickenPaint Be has been updated.
- The shortcut keys for zooming in and out in ChickenPaint Be have been changed to "+" and "-", the same as Klecks and AXNOS Paint.  
Previously, it was necessary to press the "ctrl key" at the same time, such as "ctrl + +" or "ctrl + -".  

- The file size of ChickenPaint Be has been reduced by 23.7%.  
By changing the build tool and removing the polyfill package used for IE compatibility, the file size, which was 779KB, has been reduced to 594KB.  
This weight reduction has made startup faster.  


## 2024/10/04 v6.37.6
### Lightbox Updated
- Lightbox updated to v2.11.5 and changed to a drawing board.
### AXNOS Paint Updated
- The background of the layer thumbnail images has been changed from a solid gray to a checkerboard pattern.  
This is a change in the unofficial version of AXNOS Paint. The original AXNOS Paint developer is not responsible for any issues caused by this change, so please do not contact the original AXNOS Paint developer.  


## 2024/09/30 v6.37.3
### PaintBBS NEO has been updated
PaintBBS NEO has a function to restore images when you move to another page or accidentally close the browser tab, but if you accidentally select a small canvas size when restoring, the image will be cropped to fit that small canvas size.  
Even if you then select a larger canvas size and reopen the image, the image will remain cropped small.  
With this update, you can now restore the image to its original size by selecting a larger canvas size and reopening it.  

## 2024/09/28 v6.37.2
### PaintBBS NEO has been updated
#### Images can now be restored even if the PC is turned off

PaintBBS NEO has a function to restore images when you move to another page or accidentally close the browser tab, but if the PC is turned off due to a power outage caused by lightning, images cannot be restored.  
Backup data was only saved when you moved to another page or closed the tab, so if an unexpected power outage caused by lightning occurred, the data for restoration was not saved.
To address this issue, data for restoration will be saved every 10 strokes.
Data will also be saved if the browser is closed.  
The data storage destination has been changed to local storage, similar to mobile devices.
However, this alone will still leave problems.  
Test drawing data, etc. will continue to be saved for more than a week and may be restored at unexpected times.  
Taking this into consideration, restoration data older than three days will be automatically discarded.  
Due to recent climate change, power outages due to thunderstorms are increasing.
With PaintBBS NEO v1.6.5, you can now restore your Drawing bulletin board data even in the event of a sudden power outage.  

Operation has been confirmed on PC versions of Chrome, Edge, and Firefox.  

## 2024/09/27 v6.37.0
### Now supports PHP 8.4
We created a test environment for the PHP8.4 RC version, which is scheduled to be released in November 2024, and tested POTI-board.  
As a result, we found that a deprecated error occurred in BladeOne.
Since PHP8.4 has not yet been officially released, it will be some time before BladeOne supports PHP8.4.  
For this reason, we created an unofficial patched version of BladeOne and included it.

### PaintBBS NEO update

Code that mixed substring() and slice() has been unified into slice(). (No change in behavior)

## 2024/09/19 v6.36.3
### ChickenPaint Be has been updated
- Removed unnecessary Bootstrap 3 and Bootstrap 4 legacy CSS classes.
### The singular "post" and plural "posts" are now displayed correctly.
- "1 post omitted" and "2 posts omitted" now display correctly in singular and plural.

## 2024/09/07 v6.36.1
### Updated the Paint screen template.
- Fixed a bug that caused image files such as PNG and JPEG to fail to load when continuing to draw with Klecks.
- Fixed a bug in template used with Klecks where loading a transparent PNG would result in a white background instead of transparent.
This issue was discovered late, as it did not occur when a PSD file with layer information was present.
- Fixed the 404 error message that appears when the file to save the image does not exist.
The error message displayed the file name that was included but not called directly.
### Updated AXNOS Paint
The released AXNOS Paint V2.3.0 has been remodeled for POTI-board.

## 2024/09/05 v6.36.0
### AXNOS Paint has been updated.
- The maximum and minimum canvas size set in the bulletin board are now reflected in the maximum and minimum canvas size in the AXNOS Paint Settings tab.
- If the browser's preferred language setting is anything other than Japanese, the UI now launches in English.
- The draft image loading process has been replaced with the official AXNOS Paint one.  
  
![image](https://github.com/user-attachments/assets/f086f1b0-28c5-428c-9e78-c84157d66789)
  

## 2024/08/21 v6.35.3
### Updates to AXNOS Paint derivatives
- Modified the layer compositing results to be closer to SAI and FireAlpaca.
This is currently a change to the specifications of AXNOS Paint derivatives, so if any problems with the layer compositing results occur due to this change, it is a problem with the derivative, not the original version.
- Implemented a measure to prevent repeated pressing of the post button in AXNOS Paint and Tegaki
Fixed an issue where multiple images were sent when the post button was pressed repeatedly, and were added to the list of unposted images.
Changed the communication process to comply with AXNOS Paint specifications.

## 2024/08/09 v6.35.2
### AXNOS paint has been updated.
- Resolved an issue when moving the tool palette on Mac Safari browser.  
This issue does not reproduce in the latest versions of Safari. This is an unofficial fix to address an issue occurring in Safari 14.  

## 2024/08/08 v6.35.1
### Now supports AXNOS Paint.
[What is AXNOS Paint (What is Axnos Paint) [Word article] - Niconico Encyclopedia](https://dic.nicovideo.jp/a/axnos%20paint)  
  
![Image](https://github.com/user-attachments/assets/367fc239-7897-4859-904d-08e91f5cf75e)
  
### A new setting item has been added to config.php
```
//Use Axnos Paint 
// (1: Enabled, 0: Disabled) 
define("USE_AXNOS", "1");

```
If this setting item does not exist, Axnos Paint will be used.
If you don't want Axnos Paint to appear in the paint app selection list, add the above setting.


## 2024/08/04 v6.33.8
### ChickenPaint Be Updates
- The Blur tool in the Tool Palette now has a shortcut key set to U.
This assigns all shortcut keys in the Tool Palette except for rotating the canvas and moving the hand tool.
Since rotating the canvas is already available with R+drag and the hand tool with Shift+drag, there is no need to set shortcut keys for these functions in the Tool Palette.
- The apply transform button now expands to the full width of the palette, just like in the original ChickenPaint.
This was an issue we ran into when we changed to Bootstrap 5, which was missing some needed CSS from the original ChickenPaint, so we restored some of the CSS from the original ChickenPaint.
### potiboard.php code cleanup
- The code handling matching article numbers and passwords when rendering continuations is now less nested.

## 2024/07/27 v6.33.6
### Added error message.
>"MSG051", "[Locked due to incorrect password attempts.]"

## 2024/07/27 v6.33.5
### Fixed a bug in ChickenPaint Be.
- 2024/07/13 In v6.32.9, ChickenPaint Be starts with two layers, but the transparent layer that is automatically created at that time did not work properly.
When drawing with a watercolor brush, black was dragged and the screen became black.
This issue was fixed by setting the layer color correctly.

## 2024/07/19 v6.32.11
### ChickenPaint Be has been updated.
- Added a duplicate icon to the Layer palette.
You can now duplicate layers and layer groups with one tap.
Previously you had to use a shortcut key or select duplicate from the top menu.
- Changed the Merge Down icon.
- The layer group merge icon is now in the same position as the Merge Down icon.
When you select a layer group folder, it becomes the group merge icon, and when you select a layer, it is replaced by the Merge Down icon.

![Added a duplicate icon to ChickenPaint's Layer palette](https://github.com/user-attachments/assets/75543a04-3e51-4960-9c97-571cf8e007a0)


## 2024/07/13 v6.32.9
### ChickenPaint Be updated
- Starts with a total of two layers: background layer and transparent layer.

Reduces accidents of drawing lines on a white background layer.

![image](https://github.com/user-attachments/assets/bd641562-5f49-4d27-b938-fe9b3c0d5501)


## 2024/07/05 v6.32.7

### Updated ChickenPaint Be
- If the iPad Air width or height is 820px or less and is a touch device, it will launch in mobile mode.
Previously, the width or height was 800px or less, so the app launched in PC UI when using iPad Air.

Also, the app switched to the mobile screen when the browser window size was reduced on the PC, but by adding touch device detection processing, the app will launch in PC UI when using PC.

### Updated .htaccess
- The setting was set to prohibit the calling of files with the `.json` extension. However, this also prohibits the calling of `manifest.json`, which sets the icons to be set on the home screen of PWA and smartphones. Since this makes it impossible to set touch icons, the setting was changed to allow the calling of files with the file name `manifest.json`.

### Updated the template engine BladeOne to the latest version
- BladeOne has been updated to the latest version v4.13.


## 2024/06/19 v6.32.5
![localhost_221021_59_poti-kaini-EN_potiboard5_potiboard php_mode=newpost(iPad Mini)](https://github.com/satopian/poti-kaini-EN/assets/44894014/6edfbe7e-306d-4c8e-84b4-69404441a38d) ![localhost_221021_59_poti-kaini-EN_potiboard5_potiboard php_mode=newpost(Pixel 7)](https://github.com/satopian/poti-kaini-EN/assets/44894014/16db4c3f-9fb5-415d-a051-c2849ecb7983)

The template has been updated.
The explanations for the form input fields have been made easier to understand.
The way the form is displayed on mobile devices has been changed.

## 2024/06/12 v6.32.2

### ChickenPaint Be updated

- Fixed an issue where the text on the opacity adjustment slider in the layer palette was blurred.

![image](https://github.com/satopian/Petit_Note/assets/44894014/021ccbba-4c53-4299-8655-6a188910e754)

- Increased the spacing between the tool option sliders so they can be operated with your finger.


## 2024/06/10 v6.32.1

### ChickenPaint Update
- Switch to mobile UI and collapse palette when using a device with width and height less than 768px. The UI takes up less space and you can draw on a larger canvas.

https://github.com/satopian/Petit_Note/assets/44894014/efb5fe8e-aafe-44c6-b3a0-b01b54b5c5f0

- The margins of color swatches in mobile UI have been enlarged so that they can be tapped with a finger.

### Issue where on-screen keyboard appears when tapping the drawing time clock on PaintBBS NEO drawing screen
- Added readonly attribute to prevent on-screen keyboard from appearing.
![Screenshot_20240610-103937_600](https://github.com/satopian/Petit_Note/assets/44894014/f7c27259-b996-4e5a-88ff-3a97fcf80c89)
This issue occurred before 2018.


## 2024/06/09 v6.31.23
### ChickenPaint Be Update
- The thickness of the palette title bar in smartphone mode has been increased to make collapse/expand easier.
- The spacing between the operation icons in the layer palette in smartphone mode was narrow, so it has been widened.
- Displaying both the collapse/expand icon and the close icon could lead to accidental tapping and accidentally closing the palette, so the close icon is no longer displayed in smartphone mode.
Instead, use the show/hide shortcut menu at the top.

![Screenshot_20240609-201946](https://github.com/satopian/poti-kaini/assets/44894014/e9608591-78d4-4614-a8f4-ae27900e452c) ![Screenshot_20240609-201955](https://github.com/satopian/poti-kaini/assets/44894014/c9d77422-0277-4fd8-b984-9cb624b34020)


## 2024/06/08 v6.31.22
### ChickenPaint Be Update
- The shortcut menu for hiding palettes is now always visible on devices other than smartphones and tablets.
- Further optimized responsive design for different widths.
- The color of the shortcut menu has been changed from yellow to light gray.

https://github.com/satopian/Petit_Note/assets/44894014/e2519331-4898-462f-b911-c8b483acb011


## 2024/06/07 v6.31.21

### ChickenPaint Be's Update
- The brand logo is now intentionally visible even in smartphone mode to prevent accidentally tapping the browser home button.
- The shortcut menu to hide palettes now spans the entire width of the device.
Previously, the spacing was too narrow, so it was sometimes impossible to tap the yellow shortcut menu where you intended.

![Screenshot_20240607-214641](https://github.com/satopian/Petit_Note/assets/44894014/fe33539d-959d-477d-ab33-008a9b431e7d) ![Screenshot_20240607-214737](https://github.com/satopian/Petit_Note/assets/44894014/1885f673-b6a5-49fe-801b-13b9e01e5841) ![Screenshot_20240607-214650](https://github.com/satopian/Petit_Note/assets/44894014/d9726f15-f5c8-4956-b611-e0f8c0f78a05)  
![Screenshot_20240607-214831](https://github.com/satopian/Petit_Note/assets/44894014/28eec37d-aca1-4250-a2bd-89a6eff16221)  


## 2024/06/06 v6.31.20

- In v1.36.10, we fixed the issue of the canvas size not returning to full screen after entering numerical values ​​for blurring, grid settings, etc., when using the ChickenPaint menu on a smartphone. However, there was an issue with the palette placement being misaligned when performing this operation, which remained as an issue.
We found that this issue was caused by both the modal window and the Hamburger menu being displayed, so we set it so that the display event of the modal window is obtained and the Hamburger menu is automatically closed.
This fixed the issue of the palette placement being misaligned.
- Detects changes in the orientation of the smartphone or tablet and initializes the palette placement of ChickenPaint.
In v6.31.10, we added a process to initialize the palette placement when the window size was changed, but the appearance of the on-screen keyboard when renaming a layer was detected as a window size change, making it impossible to change the layer name, so we decided to initialize the palette placement when the smartphone or tablet orientation was changed.
- If you want to change brushes while drawing, collapsing the palette each time would require more taps.
Since you can hide all palettes by tapping the shortcut menu in Mobile mode, we have removed the auto-collapse feature for tool palettes.
- Smartphone mode with collapsed palettes can now be displayed even on smartphones with large screens.

![Screenshot_20240607-141136](https://github.com/satopian/Petit_Note/assets/44894014/078b3f26-1a21-4be0-b248-8b06518b8bfe)  

![Screenshot_20240607-141149](https://github.com/satopian/Petit_Note/assets/44894014/73b84217-2216-4970-b540-1f98734da059)  


## 2024/06/01 v6.31.10
- Fixed an issue where the canvas size would not return to full screen after entering numerical values ​​for blurring, grid settings, etc., when using the ChickenPaint menu on a smartphone.
- ~~To address the issue where the layer palette would not appear in the expected position when tilting the smartphone vertically or horizontally, the palette layout is now automatically initialized when the screen is resized.
The palette layout is also initialized every time the browser window size is changed on a PC.
This also solves the issue where the palette would shift to the left when the window width was narrowed and would not return to its original position even if the window was widened again.
However, since the palette layout is initialized even if the window is changed slightly, problems may occur if you want to move the palette position while drawing.
However, it will not be initialized unless the window size is changed, so there should be no problem if you draw with a fixed browsers window size.~~


## 2024/05/28 v6.31.9
- Adjusted the operation icons of ChickenPaint Be's layer palette so that they fit in one horizontal row.

## 2024/05/26 v6.31.8
### Added horizontal flip icon to ChickenPaint Be
- Added a horizontal flip icon to the operation palette of ChickenPaint Be.  
You can now easily flip horizontally even on devices that cannot use keyboard shortcut keys.

![左右反転アイコンを追加](https://github.com/satopian/Petit_Note/assets/44894014/f01c755a-801f-4ca8-9269-d76f2d7dd446)


## 2024/05/23 v6.31.3
### ChickenPaint Be has been updated

- Updated the bootstrap used by ChickenPaint Be to v5.3.3.
- Fixed ChickenPaint Be's deprecated JavaScript syntax `returnValue`.


## 2024/05/21 v6.31.2
### twitter.com→x.com
Even if the setting is `twitter.com` or `x.com`, a SNS sharing link will now be created with the `x.com` URL.

```
// Servers displayed in the list when sharing on SNS
//Example ["Display name","https://example.com (SNS server URL)"], (comma is required at the end)
$servers =
[

	["X","https://x.com"],
	["Bluesky","https://bsky.app"],
	["pawoo.net","https://pawoo.net"],
	["fedibird.com","https://fedibird.com"],
	["misskey.io","https://misskey.io"],
	["misskey.design","https://misskey.design"],
	["nijimiss.moe","https://nijimiss.moe"],
	["sushi.ski","https://sushi.ski"],

];
```
You can now create a link to `x.com` without any problems even if the URL of X (old Twitter) in `config.php` remains `twitter.com`.
If you don't mind leaving the name of the SNS that opens in the list as "Twitter", there is no need to modify config.php.
However, the settings in `config.php` take precedence, so if you want to display the old Twitter as "X", change to `["X","https://x.com"] ,`.

## 2024/05/13 v6.31.1
### Improvement
  
- Even if Bluesky is not in the sharing list, you can now share to Bluesky by directly entering `https://bsky.app`.  
- Fixed an issue where when sharing to X, Bluesky, Misskey, etc. on a smartphone, the app version would launch and the shared server selection screen would remain on the Chrome side.  
We solved this problem by closing the screen when the focus is removed from the SNS shared server list screen.  
However, if the screen has already been moved from the list screen to an SNS site, it will not close even if the focus is removed.  
If so, it's because you're already typing or viewing a social media post.  
Also resolved the problem that occurred when using the app on a PC, where multiple SNS sharing windows remained open.  

## 2024/05/07 v6.31.0
### "Share on SNS" now supports Bluesky
![image](https://github.com/satopian/poti-kaini-EN/assets/44894014/79a98272-529c-442d-812b-b3db2a42dc1e)

```
// Servers displayed in the list when sharing on SNS
//Example ["Display name","https://example.com (SNS server URL)"], (comma is required at the end)

$servers =
[

	["Twitter","https://twitter.com"],
	["Bluesky","https://bsky.app"],
	["pawoo.net","https://pawoo.net"],
	["fedibird.com","https://fedibird.com"],
	["misskey.io","https://misskey.io"],
	["misskey.design","https://misskey.design"],
	["nijimiss.moe","https://nijimiss.moe"],
	["sushi.ski","https://sushi.ski"],

];

```
Bluesky must be added to the SNS server list in config.php.  
`["Bluesky","https://bsky.app"],`


## 2024/04/20 v6.30.8
```
const handleExit=()=>{
```
When I attempted to change `handleExit` to a constant by adding `const`, this function stopped working. To avoid that, the `handleExit` function has been moved from inside "DOMContentLoaded" to outside.

## 2024/04/16 v6.30.7
### Autolink feature now supports Internet Archive URL format
Fixed regular expressions for automatic links. Identifies `:` as part of the URL.
This allows automatic linking of Internet Archive URLs.
#### Example URL for autolink feature
`https://example.com/https://www.example.com`

## 2024/03/29 v6.30.5
### ChickenPaint has been updated.
Fixed an issue where the ChickenPaintn screen would remain scrolled and the menu bar would disappear when you finished using the iPad's onscreen keyboard.
When you rename the ChickenPaint layer, an onscreen keyboard appears and forces scrolling.
Displaying the onscreen keyboard forces the screen to scroll. And I had a problem with the keyboard not returning to its original position after it disappeared.
Fixed this issue.


## 2024/03/18 v6.30.3
### Fixed an issue where IP address check did not work when using Java Applet + IPv6
The IP address sent by the Java applet is IPv4, but the PHP script receives an IPv6 IP address.  
As a result, there were cases where posts were not determined to be by the same person.  
Fixed an issue where the image would not be displayed in the posted image list even if you posted a drawing image due to an IP address mismatch.  
Even if the IP addresses do not match, if the cookies match, the image will be displayed in the posted image list, so this problem rarely occurred.  
### "Tegaki" updated
In addition to the conventional right-click, you can now register colors in the palette by long-pressing with a pen or finger.
However, if you press the palette for a long time, it will become a long press and will register the color instead of selecting the color.
Please be careful not to press for too long when just picking up colors.
### "ChickenPaint Be" updated
Added shortcut keys. You can now invert negative and positive images using "ctrl+i".
It is also possible to invert negative and positive layer masks. You can also invert the visible area by inverting the negative/positive mask.

## 2024/03/11 v6.29.0
Due to the update of the template engine BladeOne, the operating environment has been changed to PHP7.4-PHP8.2.  
If PHP is lower than 7.4, please switch the PHP version using the server control panel etc. to PHP 7.4.0 or higher.  

## 2024/03/06 v6.28.0
### Fixed an issue where the Palette selection menu in ChickenPaint Be did not work on iPad iOS.
Fixed an issue where the ChickenPaint Be selection menu was not working in Safari and Chrome on iPad iOS.
### Fixed an issue where it was possible to post using a password other than the admin password even if the admin pass was set to be required for new posts.
Fixed a bug where new posts were made using a password other than the administrator password, even though the administrator password was set to be required for new posts.
This is a bug that has existed since v3.x.

## 2024/02/26 v6.27.9
### While drawing, the browser's default shortcut key "ctrl+o" is disabled

## 2024/02/24 v6.27.8
### Improvement
The format of article IDs sent via email has also been unified to `"?res={$resno}#{$no}"`.
### Bug fixes
Fixed an issue where `session_start()` was called in `picpost.inc.php` when the SESSION had already started, causing a minor error.
### Avoid warnings from Chrome
Avoid warnings from Chrome by explicitly setting "passive" values for ChickenPaint and PaintBBS NEO event listener handling.

### Improvement. 
Sensitive data in Java applet Shi-Painter has been changed from GET to more secure POST.

## 2024/02/21 v6.26.10
### Improvement. 
Changed sensitive data in the HTML5 version of the Paint app from GET to more secure POST.
### Bug Fix
Fixed undefined error in paint time.
Fixed an issue where Shi-Painter posting would fail when using the Waterfox Classic+Java plugin.

## 2024/02/18 v6.25.7
### Fixed a lightbox vulnerability discovered by GitHub code scanning
Fixed an issue where variable text was being interpreted as HTML.

## 2024/02/12 v6.25.5
### Improved key input restrictions for PaintBBS NEO
On the screen where NEO is running, key operations other than NEO's keyboard shortcut keys and text input could not be performed.
Therefore, it was only possible to use the right-click menu of the mouse to paste palette data to the "textarea" of the dynamic palette.
It was also not possible to edit the pasted palette data.

![image](https://github.com/satopian/Petit_Note/assets/44894014/8b5ec588-def4-4950-97b2-d4d381f75831)

By acquiring and pasting dynamic palette data, you can use your own palette on any bulletin board.
With this update, it is now possible to enter keys in the palette data input field.
Like the original PaintBBS, ctrl+v (paste) crtl+x (cut) ctrl+c (copy) crtl+a (select all), etc. can now be used in the palette data input field.

Additionally, an issue where browser shortcut keys such as ctrl+r (reload) would work when using the text input function has been fixed.

## 2024/02/09 v6.25.2
### Fixed an issue where neo's drawing animation file size became too large and could not be posted.
We fixed an issue where neo's drawing animation file size was too large for the server to handle, causing all posts containing images to fail.
If the post from neo exceeds the POST limit, we will stop posting the drawing animation file and allow the image post to succeed.

![image](https://github.com/satopian/poti-kaini-EN/assets/44894014/672a08f1-93cc-4aaa-9f0b-48041de6c631)

If you want to upload a large drawing animation file, please make the following settings in php.ini.

```
upload_max_filesize = 25M
post_max_size = 25M

```

## 2024/02/05 v6.23.1.1
### CheerpJ v3.0 supports Shi-Painter's drawing playback function and detailed settings of dynamic palette
#### CheerpJ v3.0 is now available
CheerpJ is a tool that converts Java applets to JavaScript on your browser.
Previously, with CheerpJ v2, it was not possible to adjust the brightness or create gradients in the dynamic palette of the Java applet ShiPainter or PaintBBS. 　

Unfortunately, CheerpJ v3 is designed to not work on XAMPP's Localhost, and posts by Shi-Painter will also fail.
This can be said to be a specification of CheerpJ because it only supports Java applets that are published on the Internet, not in the local environment.
#### If you need CheerpJ v2.3, set it in config.php

```
//Use an older version of CheerpJ Yes:1 No:0
//If there is a problem with the latest version, do this:1
define("USE_CHEERPJ_OLD_VERSION","1");

```
## 2024/02/03 v6.22.1
### Use "Lightbox" for pop-up displays
"Luminous" which was used to display popup images, The LICENSE file has been removed from the repository, so LICENSE is now unknown.
To resolve this issue, use a "Lightbox" to display the popup.
I'm customizing the "Lightbox" to create a "luminous" like popup.
- Make transparent PNG transparent
Since the background color of the "Lightbox" is white, I made the background part transparent so that the background of the transparent PNG image can be seen through.
- Long press on image to save
In "Lightbox", you cannot save an image by long-pressing it, so I adjusted the CSS so that you can save it by long-pressing the image.
- Reposition the forward and backward navigation bars.
The arrows that display the previous and next images that were displayed above the image have been repositioned to match the left and right width, and if there is space on the left and right, the navigation arrows will be displayed on the left and right.  
- Close button
Images now close when pressed anywhere other than the fo prev / next navigation arrows.
As a result, the close button is no longer needed.
- Image loading image
Change the loading circle GIF to two large and small circles created with transparent PNG. Rotate the image using CSS3.

## 2024/01/30 v6.21.1
### Fixed an issue where it would become impossible to post if cookies disappeared while drawing
The system that matches the cookie value set in HTML with the actual cookie value has been abolished.
Even if the cookie does not exist at the time of posting, it is now possible to reissue the user code cookie and post.
I believe that this not only addresses the issue of cookies disappearing from the user's browser, but also the issue of cookies not being able to be verified due to the server's WAF settings.
Also, information was packed in the extension header of Shi-Painter and PaintBBS NEO, but we have switched to a method of obtaining it with GET parameters instead of via the extension header.
To maintain compatibility, if it is not possible to obtain with GET, it is now possible to obtain with extension header.

## 2024/01/24 v6.20.2.5
### Updated the ChickenPaint.
- This ChickenPaint is a customized from original [ChickenPaint](https://github.com/thenickdude/chickenpaint).  
[satopian/ChickenPaint_Be Customized ChickenPaint working with Bootstrap5](https://github.com/satopian/ChickenPaint_Be)  

#### Fixed an issue where shortcut keys would not work when operating a check box or select box on a palette.  

#### ChickenPaint shortcut keys have been changed.
- Redo is "ctrl+y".
- Transform is "ctrl+h".

## 2024/01/22 v6.19.5
### Updated the ChickenPaint.
- This ChickenPaint is a customized from original [ChickenPaint](https://github.com/thenickdude/chickenpaint).
[satopian/ChickenPaint_Be Customized ChickenPaint working with Bootstrap5](https://github.com/satopian/ChickenPaint_Be)

Using icomoon, the file size required to load fontawesome fonts was reduced to 1/18.
The HTML of the dropdown menu has been unified to Bootstrap 5.3 format.


## 2024/01/14 v6.19.0
### Fixed bug
- Fixed a bug that caused "Cookie check failed" when painting.

## 2023/01/07 v6.18.5
### Updated the ChickenPaint.
- The code has been significantly updated to work with Bootstrap5 instead of the older Bootstrap4.
- Fixed minor bugs.
- This ChickenPaint is a customized from original [ChickenPaint](https://github.com/thenickdude/chickenpaint).
[satopian/ChickenPaint_Be Customized ChickenPaint working with Bootstrap5](https://github.com/satopian/ChickenPaint_Be)

## 2023/12/30 v6.17.9
### Fixed a bug in ChickenPaint's grid settings
Fixed a bug where when pressing the enter key to confirm numerical input in ChickenPaint's grid settings, the screen would move to the top of the bulletin board and the drawn picture would disappear.

## 2023/12/27 v6.17.8
### Fixed so that you can post even if the user code cookie disappears for some reason
- Fixed an issue where an error "User code mismatch" occurred and posts that were supposed to be able to post failed.
Set a user code in both the cookie and SESSION data so that it can be posted if either the cookie or the SESSION matches the user code.
- Performs a cookie check when starting drawing mode, and checks in advance whether the user code matches the user code stored in Cookie or SESSION.
Checks for problems and displays error messages before you start drawing.
This fixes an issue where drawing work is lost.


## 2023/11/30 v6.16.7
### Add shortcut key for ChickenPaint

- Press the “D” key to switch to Smudge tool.
- Press the “C” key to switch to Blender tool.

## 2023/11/30 v6.16.6
### PaintBBS NEO Shortcut Keys Fixed an issue where the Firefox menu bar would show/hide when the Alt key was released.

## 2023/11/29 v6.16.2
### Updated tegaki.js.
- Fixed an issue where keyboard shortcut keys would stop working immediately after pressing the alt key.

## 2023/11/28 v6.16.1
### Fixed bug in customized version of ChickenPaint

## 2023/11/27 v6.15.9.3
### Fixed bug in customized version of ChickenPaint
### Add shortcut key for ChickenPaint

- Press the “A” key to switch to airbrush tool.

## 2023/11/26 v6.15.9.2
### Fixed bug in customized version of ChickenPaint

## 2023/11/25 v6.15.9.1
### Fixed syntax error in customized version of ChickenPaint

## 2023/11/25 v6.15.9
### Add shortcut key for ChickenPaint

- Rotate the canvas with "R" key + left click.
- Press the "H" key to flip horizontally.
- Press the “W” key to switch to watercolor brush tool.
- Press the "S" key to switch to soft eraser tool.

https://github.com/satopian/Petit_Note/assets/44894014/2075f812-19d4-4409-9478-9bf0a49a3c59

## 2023/11/23 v6.15.8
### ChickenPaint has been updated
- ChickenPaint has been updated.

### Switch the image popup display to gallery mode when there are multiple images in the individual thread display.
- When displaying Luminous' image popup display in a separate thread, if there are multiple images, they will be displayed in gallery mode.
View previous and next images Use the arrows to view images in sequence.


## 2023/11/18 v6.15.6
### Fixd bug
Fixed an issue in "Waterfox Classic" and "Pale Moon" where an error would occur during POST from Shi-Painter started using the Java plugin.

### Improvement
- Added a corruption check function for images sent from Shi-Painter.
Added a check for image corruption that is already implemented in drawing apps other than Shi-Painter.

### Klecks Update
- Updated Klecks.


## 2023/11/07 v6.12.1
If the PNG image sent from the drawing app is corrupted, the drawing screen will not switch to the posting screen. You will then receive an error message asking you to take a screenshot.

![image](https://github.com/satopian/poti-kaini-EN/assets/44894014/9e667664-1bce-44de-99af-8e392e551f21)


## 2023/11/04 v6.11.11
### Updated Paint app
- Updated ChickenPaint.
- Updated Klecks.

## 2023/11/02 v6.11.10
### improvement
- Improved processing when JPEG images are rotated or have location information added.
Previously, when rotation or position information was detected, a JPEG image of the same size was output.
With this update, it is now scaled down to the value specified by `MAX_W_PX` and `MAX_H_PX` (for example, 1024px).
This eliminates the need to process the image a second time if the width and height exceed the specified values.
This eliminates the wasteful processing of creating a JPEG image and then creating the JPEG image again, as well as the deterioration of image quality.
### updated Klecks.
- updated Klecks

## 2023/10/29 v6.11.5
### Added the ability to reduce the size of images that exceed the specified width and height range.
This isn't about creating thumbnail images.
Reduces the size of the uploaded image itself. so, just like Discord.

### New setting items have been added to config.php

```
// The maximum size for width and height during upload, any larger will be resized.
define("MAX_W_PX", "1024"); //幅(width)
define("MAX_H_PX", "1024"); //高さ(height)

```
### Analyze the Exif
Analyze the Exif and if the image is rotated, correct it to the correct orientation.
If location information is included, it will be deleted.

## 2023/10/25 v6.10.8
JavaScript for mobile judgment processing has been externalized.
Removed unused code.

## 2023/10/23 v6.10.7
### Bug fix
The bug preventing Shi Painter from starting in version 6.10.6 has been fixed.

## 2023/10/23 v6.10.6
### The conversion conditions from PNG to JPEG have changed.

Previously, both the drawn image and the uploaded image were converted from PNG to JPEG when the `IMAGE_SIZE` setting was exceeded, but now only the uploaded image is affected by the setting.

If an error occurs and you cannot post because the posting capacity limit of `MAX_KB` is exceeded, both the drawn image and the uploaded image will be converted from PNG to JPEG.
After conversion, if the file size is reduced to a size that can be posted, it will be posted in JPEG format.


## 2023/10/21 v6.10.2
### It is now possible to configure the minimum width and height for drawing.
New setting items have been added to config.php.
```
// If a drawing size smaller than this is input, it will be the minimum value set here.
define("PMIN_W", "300");	//幅 (width)
define("PMIN_H", "300");	//高さ (height)

```
### Fixed an issue where the layout was broken when the width of PaintBBS NEO was less than 300px.

![20231021_NEOキャンバスサイズ50px](https://github.com/satopian/poti-kaini-EN/assets/44894014/31e9d039-252b-4d74-b05e-434d3c7e843a)

## 2023/10/17 v6.09.0

### improvement
- Fixed an issue where the Open in another tab button on the search screen remained disabled.
- The response display screen has been displayed faster.

## 2023/10/13 v6.08.0
### fixd bug
```
// Use the oekaki function  (1: Enabled, 0: Disabled)
define("USE_PAINT", "0"); 

//Allow admins to use all apps regardless of settings
// (1: Enabled, 0: Disabled) 
define('ALLOW_ADMINS_TO_USE_ALL_APPS_REGARDLESS_OF_SETTINGS', '1');

```
Fixed a bug where the canvas size value was not displayed on the Paint form when using this configuration combination.
### Improvement

To simplify the work, we externalized the paint form so that it can be used as a common component.

## 2023/10/10 v6.07.10
### Security Update
Added mime type check for pch files of Java's Shi-Painter and PaintBBS.

## 2023/10/03 v6.07.8
### Reduce memory consumption by 50%
Previously, with POTI-board, if 10,000 comments were recorded in the log file, even if only one comment was displayed on the reply screen, it would read the data for 10,000 comments.
To solve this problem, we have made it possible to retrieve only the necessary parts from the log file when displaying the reply screen or catalog screen.
### Improved numerical input of tegaki.js
We have updated our own modified version of tegaki.js.
Improved direct numerical input of brush size and opacity. The up arrow key increases the value and the down arrow key decreases the value.

## 2023/10/02 v6.06.1
- Optimized the display conditions for the thumbnail images of the previous and next threads at the bottom of the reply sending screen.
Split processing before and after the current thread for a more optimal display.
- Security update.
Fixed an issue where mime type was not checked when acquiring ChickenPaint specific format files.
It also checks the mime type when downloading app-specific files.


## 2023/09/21 v6.03.0

### Improvement

- Rewritten ChickenPaint's sending process to "fetch API" from old "xhr".
(PaintBBS NEO, Tegaki, and klecks have already been sent using the "fetch API")
- Change the template's "Web Style" to "Template".

- The corresponding thread is now displayed when posting a new post or replying to a post.
Previously, the top of the bulletin board was displayed when a new post was posted, and the corresponding thread was displayed when replying to a post.

### Bug fixes
Fixed an issue where validation was not performed when logging tool names to log files.


## 2023/09/11 v6.01.7
- The first and last page of paging can now be displayed. Click "Last" to display the oldest posts.
- The number of images displayed on one page when in catalog mode was fixed at 30, but can now be set.

## 2023/09/09 v6.00.10
- Fixed a minor error that occurred when accessing from a browser other than a browser without a user agent.
- Reduce the load by checking whether the drawn animation file exists before checking its extension.
- Fixed an issue where the drawing time string was wrapped.
- Corrected that the calculation part of the last update date on the search screen did not correspond to the year 2286 problem.

## 2023/08/30 v6.00.6
The image attached and uploaded is now displayed as "Tool:Upload".

## 2023/08/28 v6.00.5

### Extended log file
The name of the paint tool used is now displayed.  
Addresses the year 2286 problem.  
The type of timelapse file and the presence or absence of thumbnails are now recorded in the log file. As a result, the load can be reduced because it is not necessary to check the existence of the file each time.   
  
Log files are backward compatible.  
It can also be read with an older version of POTI-board.  
Conversely, POTI-board v6.x can also read old version log files.  
Log files do not need to be converted, you can use your existing log files.  

## 2023/08/13 v5.63.8
### Added option to hide [Admin mode] link.

#### Added this option to config.php.
```
// 顯示[管理模式]的鏈接 是：1 否：0
define("USE_ADMIN_LINK", "1");
// 否：0 在管理模式下隱藏鏈接。
```
## 2023/08/28 v6.00.6
The image attached and uploaded is now displayed as "Tool:Upload".

## 2023/08/07 v5.63.7

- klecks/  (Update directory by overwriting)
- potiboard.php
- templates/basic_tw/paint_klecks.blade.php

## 2023/08/04 v5.63.6.1
### Updated Klecks and Tegaki

- klecks/  (Update directory by overwriting)
- tegaki/  (Update directory by overwriting)


## 2023/07/28 v5.63.6

### Bug fix

- potiboard.php
- search.inc.php
(Some variables were undefined.)
- templates/basic_tw/paint_tegaki.blade.php
(When used on an iPad, the screen was being magnified by double-tap zoom.)

## 2023/07/13 v5.63.3

### You can now set the width and height of the window that opens when sharing on SNS in config.php.
Added a new setting item to config.php.

## [2023/07/12] v5.63.2
### Improved selection operability of SNS server to share posts

![image](https://github.com/satopian/poti-kaini-zh-TW/assets/44894014/063c68ed-21cc-47b9-a366-0f9e1158e5f1)

Servers to share can be selected not only directly above the label string, but also by tapping the right margin of the label.
- set_share_server.blade.php
Fixed HTML grammar errors.

## [2023/07/11] v5.63.1
### Replace search.php with search.inc.php
The structure of jsearch.php has been fundamentally overhauled, modified and incorporated into potiboard.php.
Search results that were previously displayed with a URL like `search.php?`. The URL will be changed like `potiboard.php?mode=search&`.

### Search is not case sensitive

Name searches are now case insensitive when the exact match option is selected.

## [2023/07/08] v5.62.3

### Bug fixes
Search function was not working.
This bug was introduced in v5.58.10 and fixed in v5.62.2.

### From "Tweet button" to "Twitter", "Mastodon" and "Misskey" sharing.

In addition to "Twitter", you can now share posts on short-text posting SNS such as "Mastodon" and "Misskey".

![image](https://github.com/satopian/poti-kaini-zh-TW/assets/44894014/0937a37c-ce3a-4c1a-8d01-5c33df48a904)  

You can also change it to a conventional tweet button by setting it in config.php.
You can also edit the list of "Mastodon" and "Misskey" servers.


## [2023/05/20] v5.61.2
### Added support for the drawing application tegaki.js.
![230621_tegaki_sukumizu_001](https://github.com/satopian/Petit_Note/assets/44894014/02a75d17-f94a-4e6b-8ec3-8e762d26713e)
### Improved "copy poster name" functionality.
It now add at the cursor position in the text field.
Previously, it was added at the end of the line.

## [2023/06/11] v5.60.0
### Fixed deprecated JavaScript syntax in paint app
- Updated PaintBBS NEO to v1.6.0.
- Updated to original modified version of ChickenPaint.
- The paint app Klecks has two layers at startup.

![Image](https://github.com/satopian/poti-kaini/assets/44894014/23eec76c-969a-458b-931a-2c3bb56e9201)

## [2023/05/07] v5.58.9.1
- Klecks update
- Blade One update

## [2023/05/03] v5.58.9
- klecks update

## [2023/04/25] v5.58.8
### ChickenPaint update

- Fixed an issue where the canvas aspect ratio was incorrect when ChickenPaint was launched in full screen mode on an iPad.

## [2023/04/13] v5.58.5

### ChickenPaint update
- In order to deal with the problem that the aspect ratio of the drawing area is broken when the orientation of the device is changed on the iPad, we have included a version of ChickenPaint that has been customized and built independently. (Temporary measure until the problem is resolved)
- This issue only occurs when using ChickenPaint in fullscreen mode.
- Therefore, I stopped starting in full screen mode and started in normal mode.
You can switch the display to full screen mode by selecting full screen mode from ChickenPaint's menu bar.

### Improvements

- Fix WCS dynamic palette script's deprecated JavaScript  Rewrote substr() to substring() . 
[String.prototype.substr() - JavaScript | MDN](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/substr) MDN

- Added a "Post in the same thread" checkbox.
 
![230307_continue drawing_post in the same thread](https://user-images.githubusercontent.com/44894014/223247562-6184578c-3565-4f43-8a10-2feedd5e46b1.gif)
 
Added a "Post in the same thread" checkbox.
However, in the case of "image replacement", there is no choice but to post in the same thread, so this option is unnecessary.
 
Therefore, I used JavaScript to display the "Post in the same thread" checkbox only when a new post is selected.

- bad host chek 

When a user has the same host name and IP address, we made it possible to specify a few characters from the front of the IP address displayed as the host name and reject it with a prefix match.

>$badhost =["example.com","100.100.200"];

If set like this:

"example.com" will be rejected with a suffix match, and "100.100.200" will be rejected with a prefix match.


## [2023/02/26] v5.56.3

### Updated Klecks to latest version

![Image](https://user-images.githubusercontent.com/44894014/221393538-22d0a2b5-d725-4bc9-9e97-7dd7e15fdf3b.png)

- Dark theme is now selectable.
- Added French language support.
- Fixed touch gesture freezing issue on iPhone and iPad.

### Updated BladeOne to latest version
- Updated BladeOne to v4.8.
### Improvements
- Fixed that the order of the search screen was not in the latest order.
- Improved search screen code.

## [2023/02/09] v5.56.2.2
- Added missing klecks help file.

## [2023/02/05] v5.56.2

### You can now configure whether or not to use the URL input field in config.php.

```
//使用 URL 輸入字段 是:1 否:0
define("USE_URL_INPUT_FIELD", "1");
//否：0，URL字段從表單輸入字段中消失。
// 即使表單是偽造的，也不會輸入 URL。
//No: 0, the URL field disappears from the form input fields.
// Even if the form is faked, the URL will not be entered.

```
In addition to prohibiting the writing of URLs in the text, if you can also make it impossible to write URLs in the URL field, you can eliminate advertisement spam whose purpose is to write URLs.
URL judgment of URL writing prohibition in the text is quite strict, so even if `http://` is omitted, it should be almost impossible to write URL of advertisement spam.

### Fixed an issue where the template could not be sent due to a JavaScript error when the URL or subject fields did not exist.
It's not a bug, but I've rewritten the JavaScript so that it works fine even if the template is modified by the user.

### In PaintBBS NEO, improved so that the screen does not move up and down when manipulating the canvas area such as copy and layer combination.
If the width of the terminal is large compared to the canvas size, it will not scroll even if you grab the mesh of NEO.
This is because the screen moves up and down when copying, layer merging, and Bz curve operations.
However, you can now grab and scroll the mesh when zooming in with pinch zoom.
This is to avoid inoperability.
These are implemented with inline JavaScript in NEO's paint screen, so you'll need to update the paint screen template.

![NEO_issue_230201](https://user-images.githubusercontent.com/44894014/216770678-0e5ab56d-89fa-4f39-8d72-0c71c2b022de.gif)

## [2023/01/19] v5.55.8.5
### Bug fixes
- PaintBBS NEO data was  potiboard5/templates/basic_tw/search.blade.php received at all in the environment of PHP5.6 to PHP7.x. Since it works without causing an error in PHP8.1 and PHP8.2, the discovery was delayed.
Overwrite and update `saveneo.php`.

## [2023/01/14] v5.55.8.2
### Bug fix

Fixed a bug where setting the minimum number of seconds required to draw would cause all alerts that should have been displayed as "15 sec" to be displayed as "0 seconds".
Even if this bug exists, if you set it to 60 seconds, you can post normally when it exceeds 60 seconds.
The problem was that the remaining time was not displayed accurately, and it was all "remaining 0 sec".

## [2023/01/14] v5.55.8.1
- fixd saveneo.php

Fixed an issue where depending on the content of the error that occurred, it would not be displayed as an alert and the screen would transition and fail to post.

## [2023/01/13] v5.55.8

### Changed communication of PaintBBS NEO from raw data to formData to avoid false positive error by WAF.
- In order to be able to post to the conventional oekaki bulletin board, we modified NEO, which used to send raw data, and made it possible to send header, image, and timelapse animetion data with formData.
With this change, the probability that the conventional WAF will detect NEO transmission data as an attack and block it will be greatly reduced, and the probability of successful posting will be dramatically increased.
[Added an option to send data individually with formData so that WAF does not judge it as an attack. by satopian Pull Request #94 funige/neo](https://github.com/funige/neo/pull/94)
#### Important changes
- Receipt of shi-Painter data is done by `picpost.php` as before.
However, the data of PaintBBS NEO is received by newly added `saveneo.php`.
If you forget to upload this file, you will not be able to post from NEO, so be sure to update it.
Transfer it to the same directory as potiboard.php.
Please update 

- Updated Paint screen template

```
paint.blade.php

```
A parameter has been added to switch to the formData submit mode.

### Changed the config.php

Until now, it was not possible to remove PaintBBS NEO from apps that use it, but now you can choose to use or not use NEO.
If you set it to not use all, it will be a setting that does not use the drawing function.
You can also set it to use only Klecks or only ChickenPaint.
When there is only one app to use, the pull-down menu for app selection disappears and the screen becomes clean.

### Limited by drawing time

For example, if you want to reject submissions with only lines drawn in less than 1 minute,

```
// Security timer (unit: seconds). If not set, use ""
define("SECURITY_TIMER", "");

```
It was possible to specify the minimum required drawing time with , but until now, it was effective only for Shi-Painter and PaintBBS NEO.
With this update, ChickenPaint and Klecks now have this setting enabled.
In the old method, when there was a violation, it was possible to jump to another site (for example, the Metropolitan Police Department site), but instead of that method, an alert will open "Please draw for another 30 seconds.".

## [2022/12/30] v5.52.8

### It is now possible to extract the width and height from the old Java version pch file and load it into the canvas.
All apps no longer require canvas size input when uploading an app specific file and loading it into the canvas.

![221227_006](https://user-images.githubusercontent.com/44894014/210079467-e7e3d80b-cf15-4dc1-8cb2-89dfc3f52800.gif)


## [2022/12/28] v5.52.2

### Improved. PaintBBS NEO animation file upload painting made easy.
-  It has become easier and more convenient to upload and paint PaintBBS NEO and Java Shi Painter videos from the administrator screen.
Until now, it was necessary to specify the canvas size before loading the pch animation file into the canvas.
With v5.52, you can now automatically get the canvas size from the animation file.
However, it is necessary to specify the canvas size when uploading the animation file of the Java version of PaintBBS.
For HTML5 version PaintBBS NEO, you can automatically get the canvas size when uploading animation files.

![221227_005](https://user-images.githubusercontent.com/44894014/209773098-d83a702f-dd79-49e8-9030-c2cdedee266b.gif)
↑
This is a GIF animation created to introduce the operation when uploading files in specific formats for shi-Painter, PaintBBS NEO, Klecks, and ChickenPaint from the administrator screen.
The canvas size is still 300x300, but the canvas is open at its original size.
If you can download a PSD file, why not upload it? Including the meaning of the explanation for those who were wondering, I also uploaded the ChickenPaint `.chi` file and the Klecks `.psd` file (Photoshop format). I created this GIF animation for description.

## [2022/12/24] v5.51.0
- PaintBBS NEO update v1.5.16
- Solved the problem that cookies could not be read with JavaScript when WAF (Web Application Firewall) was turned on.
If WAF is turned on, cookies are encrypted and have the httpOnly attribute.
POTI-board uses JavaScript to load cookies into static HTML files.
Therefore, with the conventional POTI-board, it was not possible to read the cookie of the form input content when the WAF was turned on.
I solved this problem by issuing a form input cookie not only in PHP programs, but also in JavaScript.
However, it is safer to use httpOnly cookies, which prevent JavaScript from reading the cookie.
There is also a drawing board that uses httpOnly cookies.
[satopian/Petit_Note_EN: Petit Note English ver.PHP script for PaintBBS,ChickenPaint, and Klecks PHP5.6-PHP8.2](https://github.com/satopian/Petit_Note_EN)
Log conversion from POTI-board is also possible.
[satopian/PetitNote_plugin: Petit Note Plugin for Drawing Board](https://github.com/satopian/PetitNote_plugin)

- Adding JavaScript to HTML files to emit cookies for form inputs increases the number of lines of inline JavaScript.
So I externalized my JavaScript.
This externalized JavaScript also includes the back to top button JavaScript and the Luminous image popup JavaScript.
We apologize for the inconvenience and the need to update templates frequently.
A directory for JavaScript has also been added, such as `templates/mono_en/js/`.
Please note that if you forget to upload this directory, things like the back button that appears when you scroll down or the JavaScript that appears on the same screen when you click on an image will not work.
Overwrite everything in the `templates/` directory if you haven't customized the templates.
Just upload all new installations.

## [2022/12/21] v5.50.11

### Improvements

- Changed the format of the canvas size pull-down menu formula generation loop to prevent XSS.
- Removed self-closing tag due to warnings when checked by [W3C Markup Validation Service](https://validator.w3.org/).
- Add same-origin check. Illegal posts from different origins are now rejected.
However, for browsers that do not support Orijin headers, such as Edge's IE mode, Orijin headers are not checked.
This is because if this check becomes mandatory, it will not be possible to start the shi-painter using Java.
CheerpJ, for example, cannot smoothly play Shi-Painter's drawing animation, so Java must be started.
- Protection against directory traversal attacks. Invalidate hierarchies such as `../../` in basename() when variables are entered in fopen().
- Rejection when the password is incorrect 5 times in a row.
If you enter the wrong administrator password five times in a row, you can now refuse to enter it any more.
If you want to use this function, please add the following setting items anywhere in config.php.

> /*safety*/
> 
> //Reject if admin password is wrong for her 5 times in a row
> // (1: Enabled, 0: Disabled) 
> // 1: Enabled for more security, but if the login page is locked it will take more effort to unlock it.
> 
> define("CHECK_PASSWORD_INPUT_ERROR_COUNT", "0");
> 
> // Access via ftp etc.
> // Remove the `templates/errorlog/error.log` and you should be able to login again.
> //This file contains the IP addresses of clients who entered an incorrect admin password.
> 

- Changed the method to get IP address and host name because some servers cannot get IP address with getenv().
- Use uniqid() to emit user-code repcode. It now changes in micro time units.
- Increased the replacement code length from 8 to 12 characters.

- Added original error message for WAF false positive to PaintBBS NEO.

![Screen-2022-12-21_14-34-31](https://user-images.githubusercontent.com/44894014/208915842-51352610-9abc-46b1-b4c1-8403a51bb573.png)


## [2022/11/30] v5.36.8

### update
- Updated Klecks.
 Fixed brush shortcut key behavior.
- Updated BladeOne to v4.7.1.

### improvement
- Even if the timestamps used in the working files overlap, advance the post time by 1 second so that the timestamps do not overlap.
Previously, the working file could be overwritten by another file.

- An error does not occur when the post time to be compared is in the future.
In the post waiting time calculation process, even if the post time after the current time is detected, it will not be an error.
For example, if the posting time is delayed by one year due to some mistake, the next posting will not be possible until one year has passed. To avoid this, if the waiting time is a negative value, it will pass without generating an error.

- BladeOne v4.7.1. Along with that, I changed potiboard.php to automatically generate the cache directory.
The cache directory auto-generation feature has been removed from BladeOne. As an alternative function, added a cache directory auto-creation function to potiboard.php.

- Change the permission of files that need to be written in advance to 0606 (606). The log file that cannot be viewed externally is 0600 (600).

- The types of error messages have increased when posting OEKAKI images fails.

[Release POTI-board EVO zh-TW v5.36.8 released.](https://github.com/satopian/poti-kaini-zh-TW/releases/latest)


## POTI-board EVO v5.35.3 release
## [2022/10/29] v5.35.3

### Improvements
#### Template Common
- When you click the image file link on the management screen, it now pops up with luminous.
Previously, images were opened in separate tabs.
- Corrected [tweet] to [Tweet].
- Corrected [TOOL] to [Tool].

#### Template MONO
- Added back to top page function that is displayed when scrolling to template MONO.
- Display optimized for smartphones. If the resolution is iPad (768px) , unfloat the image. Set the image margins to 0.
As a result, the left and right margins of the image displayed on the smartphone are the same.
Previously, the margin on the right side of the screen was larger.
・The administrator can now edit the article by clicking the article number on the MONO administrator deletion screen.

### Security

- If the script content of CheerpJ Applet Runner has been tampered with by hacking, etc., it will be detected and the script will not be executed.
[Subresource Integrity](https://developer.mozilla.org/en/docs/Web/Security/Subresource_Integrity) See MDN.
If you change the version of CheerpJ, it will not work unless you change the hash value.
However, the calculated hash value is included in the latest version of potiboard.php
・If the image file received by picpost.php, which receives data from the Shi applet or PaintBBS NEO, is not  jpeg, png, etc. image, it will be judged as illegal and deleted.

### When using Shii applet and PaintBBS NEO, the behavior of rejection due to the time required for drawing or the number of steps required has been changed.

・shi-chan has developed a function to redirect the drawing screen to the police site when the drawing time is short or the number of drawing processes is small.
However, this feature was impractical and of no use.
Therefore, instead of suddenly jumping to the specified URL from the drawing screen, we changed the specification to display an alert on the drawing screen that "drawing time is too short" and "the number of steps is low".
  
![221027_002 Issue an alert when the NEO drawing time or number of processes is insufficient. ](https://user-images.githubusercontent.com/44894014/198825566-dc572087-a49a-4ec4-b79b-4d0bdaa18c04.gif)

### Compulsory thumbnail function is back
- Restored the force thumbnail feature that was in v1.3.
Using the latest `thumbnail_gd.php` turns this feature on.
If the file size exceeds 1MB, a thumbnail image in jpeg format will be output.
Assumed case. If a GIF animation image file that is small in height and width but large in file size exceeds 1 MB, a thumbnail image in JPEG format will be displayed instead of the GIF animation.
Click the image to view the original GIF animation.

### others
- Changed the initial error message to switch automatically between Japanese and English.
- Reduce load by avoiding unnecessary processing. For example, if there are no comments, you don't have to check the length of the comment or the bad words, so returning immediately reduces the load.

### update Klecks
Fixes an issue where white fills after using distortion tool show lines that follow the shape of the Liquify.
Added how-to video link to help page and added gradient shortcut keys section.

## [2022/10/03] v5.26.8

### Updated ChickenPaint to the latest version.

![ChickenPaint_Chrome106_bug](https://user-images.githubusercontent.com/44894014/193561979-a99928d2-5e4d-4265-8e20-1f42cb630599.gif)

The attached image is a GIF animation when I did a reproduction test of the problem that the color picker is not displayed.
Updated to the latest version of ChickenPaint to avoid a bug in Google Chrome 105,106 that causes this problem.

### Updated klecks to the latest version.

- Added option to use gradient tool as an eraser.
- Added vanishing point filter.

### Display images using luminous.

![luminous](https://user-images.githubusercontent.com/44894014/193562309-209f2623-0969-4726-8285-203932641057.gif)


## [2022/09/20] v5.26.3
### Update
- Updated Klecks to latest version.
Gradient tool and pattern filter added.
- Updated BladeOne to v4.6.
### Bug fixes
- Fixed a bug that an E-WARNING level PHP error occurred when specifying an article number other than the article number of the thread's parent on the reply screen.
Please update `potiboard.php`.
### Improvements
- If the password field is blank for password authentication when drawing a continuation or download authentication of pch, chi, psd, the cookie password will be used instead.
Unified to the same behavior as password authentication during edit function.  
- Fixed function `check_password()` for password checking. Password authentication will not succeed if no password is entered and the password is not present in the cookie.  
- Fixed the multilingual support of the mail notification function was insufficient.
- Fixed paint screen's clock javascript .
- Changed the unit of file size on the managed post screen from bytes to kb.


## [2022/08/16] v5.23.8
### Update
- Updated Klecks to the latest version.
Added noise filter.
    
![image](https://user-images.githubusercontent.com/44894014/184851491-b2f1bccb-c55e-40c8-b40a-87304725c811.png)

- Updated BladeOne to v4.5.5.
- Updated jQuery to v3.6.0.
Since the existence of the file is checked, the program will not run if the included jQuery does not exist.
The  case an error message telling you that the file does not exist.

### Improvements
- Fixed clickjacking vulnerability.
It will not be possible to display in frames or iframes.
It's more secure, but I know some people want to display it in a frame.
Therefore, we added a new setting item to config.php so that you can select whether or not to display it in the frame.
If you do not need to display in the frame, you do not need to add setting items.
```
// Deny display in iframe:  (1: Deny, 0: Allow)
// We strongly recommend "Deny" to avoid security risks.
define('X_FRAME_OPTIONS_DENY', '1');

```
I think it is difficult to rewrite config.php from scratch, so if you add the above setting items anywhere, you will be able to display it in the frame.

- Improved mobile usability.
Optimized tap target size and spacing.

- Improved page loading speed
Prefetch externally loaded JavaScript such as jQuery and loadcookie.js to avoid rendering blocking.
- JavaScript execution timing to `DOMContentLoaded`.

- Fixed a fatal error if not written carefully. error() function to built-in function die().
  
- Enabled to change the jQuery version without touching the template directly.
- Added width and height of image in search screen.
- In order to speed up loading speed, loading="lazy" is not applied to the range displayed from the beginning.
- The JavaScript description of the timer under the PaintBBS startup screen was deprecated, so it has been fixed.
[After setting the content security policy, the clock on the drawing screen of POTI-board stopped working. ｜Satopian｜note](https://note.com/satopian/n/n7b757ee05975)


## [2022/07/11] v5.20.2
### Improvement
- Reduced the probability of duplicate file names when posting drawing images to 1/1000.
- Even if it is duplicated, 1 second will be added to the posting time.
- Add a process to check if there is a posted image, make sure that the drawn image is sent to the server, and then move from the drawing screen.
### Update
- Klecks has been updated. Added a grid to the editing function.
- BladeOne has been updated. A minor bug has been fixed.  


## [2022/05/25] v5.18.25
### Improvement
- ChickenPaint now launches in full screen.

More information can be found in the release.    

## [2022/06/30] v5.19.1
- Since it was confirmed that it does not work with PHP7.1, the required operating environment has been changed to PHP7.2 or higher.
In the PHP7.1 environment, it will not start and will issue an error message telling you that the PHP version is low.
- The form is not displayed when there is no unposted image.

## [2022/05/25] v5.18.9
### Klecks update
Updated Klecks to the latest version.
### CheerpJ update to v2.3
Updated CheerpJ, which converts Java applets to JavaScript when using the painter, to v2.3.
### Bug fixes
 - Fixed a bug where unnecessary spaces were inserted when editing text.
 - Fixed a bug that the rejected character string and rejected url for anti-spam could not be processed correctly if they contained `/` (slash).
 - Fixed a minor error when calculating the number of days elapsed for deleting temporary unnecessary files.
 - Fixed the problem that the date and time when closing the reply in the specified number of days was not the parent's posting date and time but the latest reply posting date and time.
 - Fixed the problem that the color specification of "Size" text on the Paint form was different from other text.


## [2022/04/28] v5.16.8

### Klecks has been updated.
- Several issues with the iPad OS have been fixed.
- Traditional Chinese has been added to the available languages.

### The template engine BladeOne has been updated.

- BladeOne has been updated to v4.5.3.

### Improvement

- If the cause of the transmission failure of klecks is a server error, the error number is displayed as an alert.
For example, if `saveklecks.php` does not exist ," Error 404 "will be displayed in the alert.

- Changed the working directory of the PNGtoJPEG process to `TEMP_DIR`.
Even if the process fails and the working files are left behind, they are now automatically deleted over time.

### Bug fixes
- When the `.pch` save directory was specified other than`'src/'`, the automatic directory creation function did not work and the required files could not be saved.
Changed to be created automatically when the directory does not exist.


## [2022/04/02] v5.16.5.1
- fix search template.
Fixed a grammatical error in the HTML of the search screen.
Fixed an issue where links from image lists could not be opened correctly.
- klecks updated
The number of layers that can be used has been increased from 8 to 16.


## [2022/03/25] v5.16.5

### Improvement
### Klecks Japanese translation
![image](https://user-images.githubusercontent.com/44894014/160145766-395c519f-e90e-4397-a92e-03005648906e.png)

- Translated Klecks into Japanese.
I was able to bundle a Japanese version with POTI-board.
This new version of Klecks will automatically detect your browser's language priority and switch languages ​​for you.
You can also specify the language to use regardless of the browser language setting.
You can select English, German, or Japanese.
Chinese is only in Simplified Chinese and details are still in English.
Japanese translation resources have already been merged into the klecks repository.

### The download button for the application-specific file has been created.
![image](https://user-images.githubusercontent.com/44894014/160227733-b57a5783-d95a-4648-b484-5e065b2b7402.png)

#### App-specific format list
- `. Pch` file (PaintBBS)
- `. Chi` file (ChickenPaint)
- `. Psd` file (Klecks)

The file containing the layer information for Klecks is a `.psd` file in Photoshop format.
The downloaded `.psd` file can be opened by CSP, SAI and many other apps.
`.pch` and` .chi` can be opened with NEO and ChickenPaint, respectively.
If you attach `.pch`,` .chi`, `.psd` from the administrator posting screen and press the paint button, you can load it on the canvas and post it.

#### Transparent PNG, change the transparent part of the thumbnail of transparent GIF to white

- Fixed the problem that the transparent part of transparent PNG was black when it was converted to JPEG.
It is not a mistake that the transparent color is black, but since it often results in unintended results, when converting from transparent GIF or transparent PNG to JPEG, the transparent color is converted to white.

### Bug fixes

- Fixed the case where a minor error occurred when operating the upload format specific to the paint application used when logging in to the administrator, and the automatic deletion function of unnecessary temporary files such as pch, chi, and psd.
### BladeOne update
Updated template engine BladeOne to v4.5.

## [2022/03/12] v5.12.0
### Bug fixes
- Fixed the issues that the menu could not be operated with Apple Pencil.
Fixed that the menu operation of ChickenPaint and Klecks could not be operated with.
It was caused by Javascript added to the paint related template in v3.19.5.
I deleted the corresponding Javascript and confirmed that it works normally.
### Updated Klecks
- Updated Klecks to the latest version.
A new brush has been added. You can now do mirror painting.


## [2022/03/8] v5.10.0

### new function
- You can use the new painting app Klecks.

![image](https://user-images.githubusercontent.com/44894014/157234120-d806d24f-2f2b-4600-9d29-515a5743efd6.png)

Easy-to-understand UI, powerful brushes, and filter functions.
You can use 8 layers.
### fix
Many minor bugs have been fixed.


## [2022/02/10] v5.05.0

### URL blacklists
When the character string specified by the "String blacklists" exists in the URL, it is now rejected.
In addition, we have added a "URL blacklists" .
```
// URL blacklists  
$badurl = array("example.com","www.example.com");
```

Previously, no spam word checking was done on the URL.

### Older threads don't show links to draw more. Do not allow the continuation to be drawn.

There was a function to lock the editing of articles that exceeded the specified number of days, but I was able to draw the continuation.
I created these settings because the article will be modified if the password is compromised by a third party.
Even if the article is locked, it can be deleted by the user.
In addition, the administrator can edit even after the specified number of days.

However, I think that some people may be in trouble if the lock is applied within a certain number of days.

`define ('ELAPSED_DAYS', '365');`

Threads older than 1 year will be locked in `365`,

`define ('ELAPSED_DAYS', '0');`
  
If set to `0`, it will not be locked.

- If the specified number of days has passed while drawing, it will be a new post.
Also, when the thread is deleted while drawing, it will be a new post.

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

### [2021/09/28] v3.07.5

#### Minor bug fixes
 - Fixed the problem that the Paint BBS menu was displayed strangely when the browser language was other than Japanese.

 - Fixed the processing specification that determines whether to start the drawing time calculation.
 - Even if an error occurs during the posting process, you can repost the drawing image from the unposted image. Moved work file deletion to almost the end of the post process. Previously, if an error occurred in the second half of the posting process, the posted illustration would remain on the server but could not be displayed on the bulletin board.

#### Improved auto-complete for Chrome and Firefox

When editing or deleting an article, if you enter the article number and press the edit button, the password may be saved as a set with the user name as the article number.


To avoid this problem, I created a separate input field hidden by CSS.
This makes it easier to save passwords that use your name as your username.


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
  

### [2021/08/06] v3.05.2.2
- ChickenPaint has been updated to fix many iOS related bugs. Bugs related to palm rejection have been resolved.  
You can now recognize your palm and Apple Pencil. Until now, unintended straight lines have occurred.  

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

