# 檔案架構(暫時)
```
logistics_tracking_system
        |-- /css
                |-- styles_of_home.css
                |-- styles_of_list.css
                |-- styles_of_login.css
        |-- /profile_info
                |-- buyer.php
                |-- seller.php
                |-- driver.php
        |-- home.php
        |-- config.php
        |-- logout.php
        |-- buyer_login.html
        |-- seller_login.html
        |-- driver_login.html
        |-- buyer_auth.php
        |-- seller_auth.php
        |-- driver_auth.php
```
# 檔案內容說明
## home.php
系統首頁<br>
> 功能：<br>
>> 使用者選擇登入方式，進入 *{user}_login.html*

## config.php
phpmyadmin 資料庫系統連線<br>
> 功能：<br>
>> 登入資料庫<br>

但參數不宜直接放在檔案中，更好的做法是
- [ ] 再寫一個 .env 存放登入參數<br>
- [ ] 寫 .sql 統一建置相同的資料 (necessary)

## buyer_login.html / seller_login.html / driver_login.html
*{user}_login.html*<br>
買家登入頁面 / 賣家登入頁面 / 司機登入頁面<br>
> 功能：<br>
>> 輸入登入憑證 (id 與 password)，並送出輸入表單至 {user}_uth.php<br>
**頁面內容大部分相似，但表單參數不同，可能考慮是否能以網站框架整合此 3 頁面，但不確定可行性**

## buyer_auth.php / seller_auth.php / driver_auth.php
*{user}_auth.php*<br>
賣家登入驗證 / 賣家登入驗證 / 司機登入驗證<br>
> 功能：<br>
>> 從 *config.php* 引入與資料庫的連線；<br>
>> 執行各自的 SQL 查詢；<br>
>> 建立 session 紀錄登入狀態的參數與使用者輸入的參數；<br>
>> 跳轉頁面至登入狀態<br>
>>> 登入失敗 -> 定位至 home.php<br>
>>> 登入成功 -> 定位至 *{user}.php*<br>

## buyer.php / seller.php / driver.php
*{user}.php*
使用者登入後的頁面<br>
> 功能：<br>
>> 載入頁面頁面的同時登入狀態 (利用 `$_SESSION["loggedin"]`)；<br>
>> 顯示登入後頁面 (利用 session 接收參數)<br>

**查詢所有訂單、個別查詢訂單內容都以從此頁面繼續寫下去 (可能用 javascrpt 新增元素的方式寫)**
- [ ] 查詢所有訂單
- [ ] 個別查詢訂單內容

## logout.php
設定登出狀態<br>
> 功能：
>> `$_SESSION["loggedin"]` 讓使用者無法以返還上一頁查看登入內容，並定位至首頁 *home.php*

# 網站架構圖
                                            +------------+
         +--------------------------------> |  home.php  | <----+--------------------------------+
         |                                  +------------+      |                                |
         |                  ↙                      ↓            |         ↘                      |
         |   +------------------+       +-------------------+   |      +-------------------+     |
         |   | buyer_login.html |       | seller_login.html |   |      | driver_login.html |     |
         |   +------------------+       +-------------------+   |      +-------------------+     |
         |             ↓ POST                      ↓ POST       | fail          ↓ POST           |
    fail |   +------------------+       +-------------------+   |      +-------------------+     |  fail
         +-- |  buyer_auth.php  |       |  seller_auth.php  |---+      |  driver_auth.php  | ----+ 
            +------------------+       +-------------------+           +-------------------+
                       ↓ success                   ↓ success                    ↓ success
                +-------------+             +--------------+             +--------------+
                |  buyer.php  |             |  seller.php  |             |  driver.php  |
                +-------------+             +--------------+             +--------------+
                
# Reference 
https://docs.google.com/document/d/1J_vky-N4zJmSwBjDRI57ZVCPwn_VRQpZ8BRyxAVdNRU/edit

test

