<?php
/*
  * Template - PINK - lot.lot.210309  by さとぴあ  >> https://pbbs.sakura.ne.jp/
  *
*/

//theme version
define('TEMPLATE_VER', "lot.210309");

//General message

//Honorific title when quoting the poster name
define('HONORIFIC_SUFFIX', 'さん');//hogeさん, in Chinese?
//Uploaded object type name
define('UPLOADED_OBJECT_NAME', '圖片');
//Message when upload is successful
define('UPLOAD_SUCCESSFUL', '上傳成功');
//Message when the screen is changeed after posting is completed
define('THE_SCREEN_CHANGES', '切換畫面');

//Message for notification mail
define('NOTICE_MAIL_TITLE', '標題');
define('NOTICE_MAIL_IMG', '圖片');
define('NOTICE_MAIL_THUMBNAIL', '縮圖');
define('NOTICE_MAIL_ANIME', '過程');
define('NOTICE_MAIL_URL', '固定鏈接');
define('NOTICE_MAIL_REPLY', '通知：帖子有新回覆。');
define('NOTICE_MAIL_NEWPOST', '通知：有一個新帖子');

/* ---------- ADD:2004/06/22 ---------- */
//エラーメッセージ
define('MSG001', "找不到日誌");
define('MSG002', "您尚未選擇圖片，您必須上傳圖片。");
define('MSG003', "上傳失敗<br>服務器可能不支持它");
define('MSG004', "上傳失敗<br>僅可以附加圖像文件");
define('MSG005', "上傳失敗<br>圖片已存在");
define('MSG006', "請不要獲得未經授權的訪問。<br>您只能以POST發布。");
define('MSG007', "圖片不存在");
define('MSG008', "請寫點東西");
define('MSG009', "請輸入你的名字");
define('MSG010', "請輸入標題");
define('MSG011', "評論太長");
define('MSG012', "名字太長");
define('MSG013', "電子郵件太長");
define('MSG014', "標題太長");
define('MSG015', "未知錯誤");
define('MSG016', "發布被拒絕<br>此主機已被禁止發布。");
define('MSG019', "未能讀取日誌");
define('MSG020', "請稍等一下再發表");
define('MSG021', "請稍等一下再發表");
define('MSG022', "不久前，您發表了同樣的留言。<br>請發表另一條留言。");
define('MSG023', "它沒有更新樹");
define('MSG024', "刪除樹失敗");
define('MSG025', "線程不存在");
define('MSG026', "這是最後一個線程，無法刪除。");
define('MSG027', "刪除失敗。（用戶）");
define('MSG028', "找不到文章或密碼錯誤。");
define('MSG029', "密碼錯誤。");
define('MSG030', "刪除失敗。(管理員權限	)");
define('MSG031', "請輸入編號");
define('MSG032', "發布被拒絕<br>非法字符串。");
define('MSG033', "刪除失敗<br>用戶沒有刪除權限");
define('MSG034', "上傳圖片失敗<br>圖片尺寸太大");//? File size kb, not with height
define('MSG035', "必須輸入CJK漢字字符。");
define('MSG036', "您無法在正文中張貼網址");
define('MSG037', "您不能使用該名稱。");
define('MSG038', "包含無法使用的TAG。");
define('MSG039', "不能僅發布文本。 我需要一張照片。");
define('MSG040', "未設置管理員密碼。。");
define('MSG041', "不存在");
define('MSG042', "不可讀");
define('MSG043', "不可寫");
define('MSG044', "未設置MAX LOG，或者它包含非數字字符串。");
define('MSG045', "請上載繪圖過程記錄的文件。<br>支持的格式為pch和spch。");


/* ---------- ADD:2004/02/03 ---------- */

//描画時間の書式
//※日本語だと、"1日1時間1分1秒"
//※英語だと、"1day 1hr 1min 1sec"

define('PTIME_D', 'day');//I don't know the format for Chinese.
define('PTIME_H', 'hr');//Therefore, the items here are in English.
define('PTIME_M', 'min');
define('PTIME_S', 'sec');

//＞が付いた時の書式
//※RE_STARTとRE_ENDで囲むのでそれを考慮して
define('RE_START', '');
define('RE_END', '');

//Format when > is attached
//Since it is sandwiched between RE_START and RE_END, 
//it is recommended to set it with css considering. (do not change it here)
define('NOW_PAGE', '<span class="parentheses">[<span class="page_number"><PAGE></span>]</span>');

//Format of other pages
//The number of pages is entered in <PAGE>
//<PURL> is the URL
define('OTHER_PAGE', '<span class="parentheses">[<span class="page_number"><a href="<PURL>"><PAGE></a></span>]</span>');


/* -------------------- */

//Main template file
define('MAINFILE', 'pink_main.html');
//Reply template file
define('RESFILE', 'pink_res.html');

//Other template files
define('OTHERFILE', 'pink_other.html');

//Drawing template file
define('PAINTFILE', 'pink_paint.html');

//Catalog template file
define('CATALOGFILE', 'pink_catalog.html');

// Number of columns in the catalog (horizontal)
define('CATALOG_X', '3');

// Number of lines in the catalog (vertical)
define('CATALOG_Y', '6');

//Catalog image width.
define('CATALOG_W', '300');

//Mark when editing
define('UPDATE_MARK', ' *');

//Date format
//※<1> に漢字の曜日(土・日・月など)が入ります
//※<2> に漢字の曜日(土曜・日曜・月曜など)が入ります
//※他は下記のURL参照
//  http://www.php.net/manual/ja/function.date.php
//define(DATE_FORMAT, 'Y/m/d(<1>) H:i');
define('DATE_FORMAT', 'Y/m/d(D) H:i');

//管理画面(削除モード)の奇数行カラー
define('ADMIN_DELKISU', 'FFDDF1');

//管理画面(削除モード)の偶数行カラー
define('ADMIN_DELGUSU', 'FFD0EE');

?>
