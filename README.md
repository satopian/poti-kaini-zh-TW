# 繪圖留言板 PHP script POTI-board 改二的中文翻譯version
## 這是POTI-board 改二的繁體中文翻譯version.
This is the traditional Chinese translation version of POTI-board kai ni.  
這是日語顯示的原文.  
[satopian/poti-kaini: お絵かき掲示板PHPスクリプトPOTI-board改二, for PHP7 (PHP5.5～, 7.x, 8.0)](https://github.com/satopian/poti-kaini)  
存儲庫管理員依靠Google翻譯，因為它只懂日語.  

###
[繪圖留言板](https://pbbs.sakura.ne.jp/cgi/neosample/poti-board-zh-TW/index.html)(繁體中文)
  
###
  
![image](https://user-images.githubusercontent.com/44894014/117331996-480b5700-aed2-11eb-8580-297e4c6268e5.png)  

### Overview of required work.
There is a language resource for messages in `template_ini.php`, such as error messages and messages used when images are uploaded successfully.  
The HTML of the template uses Japanese, so we need to translate it.  
We also need to translate the external search programs `search.php` and `search.html`.    
However, potiboard.php externalizes all language settings, so no changes are needed.  
Translation of `config.php`. We need to translate the description of the settings.    
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

