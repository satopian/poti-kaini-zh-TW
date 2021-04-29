# 繪圖板 PHP script POTI-board 改二的中文翻譯version
## 這是POTI-board 改二的繁體中文翻譯version.
This is the traditional Chinese translation version of POTI-board kai ni.  
這是日語顯示的原文.  
[satopian/poti-kaini: お絵かき掲示板PHPスクリプトPOTI-board改二, for PHP7 (PHP5.5～, 7.x, 8.0)](https://github.com/satopian/poti-kaini)  
存儲庫管理員依靠Google翻譯，因為它只懂日語.  
### Overview of required work.
`template_ini.php` has language resources for messages such as error messages and successful image uploads.  
There is also Japanese to translate in the `template HTML file`.  
We also need to translate the body of `search.php` and` search.html`.  
However, POTI-board.php externalizes all language settings, so no changes are needed.  
Translation of config.php requires translation of the descriptive text for the end user to set.    

### [2021/04/29]  
- I translated only a part of `config.php`. I was careful not to change the meaning, but this also needs to be replaced with an appropriate translation.  
- お絵かき設定(paint mode settings).This item will be translated from now on. Advanced settings will not be translated.  
- I have translated all the major files except `config.php`.  
However, it relies on Google Translate, and we don't know what words are used on the bulletin board in the case of Traditional Chinese, so we need to replace them with the appropriate translations.  

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

