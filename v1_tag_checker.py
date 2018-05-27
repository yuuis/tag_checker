# coding: UTF-8
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as ec
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.common.action_chains import ActionChains
import subprocess
import pandas as pd
import sys
import re
import requests

sys.setrecursionlimit(10000000)
args = sys.argv

log_name = '/tmp/phantomjs.log'
phantomjs_options = ["--ignore-ssl-errors=true", "--ssl-protocol=any"]

user_agent = 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36' 
dcap = {
  "phantomjs.page.settings.userAgent" : user_agent,
  'marionette' : True
}


# 基礎情報の受け取り
url = args[1]
tracking_code = args[2]

# 配列の宣言
nomal = []
abnomal = []
none_tracking_code = []
done = []


def func(links):
  content = []
  if links:
    for link in links:
      if link:
        # linkがドメインを含む or linkが../を含む or "../" in link
        if url in link or "../" in link or link[0] == "/":
          print("url:" + link)
          link = re.sub("/[2*]", "", link)
          # linkがクロール済みでない
          if link not in done:
            done.append(str(link))

            # ドライバの起動
            inner_driver = webdriver.PhantomJS(service_log_path = log_name, desired_capabilities = dcap, service_args=phantomjs_options)
            inner_driver.set_window_size(1024, 768)
            inner_driver.get(str(link))

            # console, ソース, gaタグの有無を取得
            log = inner_driver.get_log("browser")
            source = inner_driver.page_source
            gatag_exist = tracking_code in source

            # 外部jsファイルを読んでscriptに格納
            row_scripts = inner_driver.find_elements_by_tag_name("script")
            script = []
            for scr in row_scripts:
              if scr.get_attribute("src"):
                script.append(scr.get_attribute("src"))
            print(script)

            # gaタグがあり、consoleが空なら正常配列に格納
            # gaタグがあり、consoleが空でなければ異常配列に格納
            # gaタグがなしならタグ無し配列に格納
            if gatag_exist:
              if not log:
                nomal.append(str(link))
                print("nomal appended")
              else:
                abnomal.append([str(link), log])
                print("abnomal appended")
            else:
              # script全てにアクセスしてその中にトラッキングコードがあるか調べる
              script_driver = webdriver.PhantomJS(service_log_path = log_name, desired_capabilities = dcap, service_args=phantomjs_options)
              for scr in script:
                print("script_url =" + str(scr))
                script_driver.get(str(scr))
                script_source = script_driver.page_source
                script_tag_exist = tracking_code in script_source
                if script_tag_exist:
                  print("find")
                  break
              if script_tag_exist:
                nomal.append(str(url))
                print("nomal appended")
              else:
                none_tracking_code.append(str(link))
                print("none_tracking_code appended")
              script_driver.quit()

            # urlをキーに、linkの中のaタグを格納
            row_content = {}
            row_content[link] = inner_driver.find_elements_by_tag_name("a")

            #row_contentの中身分ループ 
            for key, cont in row_content.items():
              if cont:
                # contentの中身分ループしてlinkごとのリンク配列を作成
                for c in cont:
                  content.append(c.get_attribute("href"))

            inner_driver.quit()

  print("--page end--")
  return content

# ドライバの起動
try:
    driver = webdriver.PhantomJS(service_log_path = log_name, desired_capabilities = dcap, service_args=phantomjs_options)
except Exception as error:
    print(error)
driver.set_window_size(1024, 768)
print("start")


# linksにトップurlのaタグを格納
try:
    driver.get(str(url))
except Exception as error:
    print(error)
driver.set_page_load_timeout(5)
row_links = driver.find_elements_by_tag_name("a")

# console, ソース, gaタグの有無を取得
log = driver.get_log("browser")
source = driver.page_source
gatag_exist = tracking_code in source

# 外部jsファイルを読んでinner_scriptに格納
row_scripts = driver.find_elements_by_tag_name("script")
script = []
for scr in row_scripts:
  if scr.get_attribute("src"):
    script.append(scr.get_attribute("src"))

# gaタグがあり、consoleが空なら正常配列に格納
# gaタグがあり、consoleが空でなければ異常配列に格納
# gaタグがなしならタグ無し配列に格納
if gatag_exist:
  if not log:
    nomal.append(str(url))
    print("nomal appended")
  else:
    abnomal.append([str(url), log])
    print("abnomal appended")
else:
  # script全てにアクセスしてその中にトラッキングコードがあるか調べる
  script_driver = webdriver.PhantomJS(service_log_path = log_name, desired_capabilities = dcap, service_args=phantomjs_options)
  for scr in script:
    script_driver.get(scr)
    script_source = script_driver.page_source
    script_tag_exist = tracking_code in script_source
    if script_tag_exist:
      print("find")
      break
  if script_tag_exist:
    nomal.append(str(url))
    print("nomal appended")
  else:
    none_tracking_code.append(str(url))
    print("none_tracking_code appended")
  script_driver.quit()


# linksにurlを格納
links = []
for link in row_links:
  links.append(link.get_attribute("href"))

driver.quit()

# リンクがある分だけfuncを実行
while links:
  links = func(links)

# 一番長い配列を求める
nomal_length = len(nomal)
abnomal_length = len(abnomal)
none_tracking_code_length = len(none_tracking_code)
max_length = nomal_length

if max_length < abnomal_length:
  max_length = abnomal_length
if max_length < none_tracking_code_length:
  max_length = none_tracking_code_length


# csv出力用の配列をつくる
cont = 0
csv_write = []
while cont < max_length:
  if cont < nomal_length:
    nom = nomal[cont]
  else:
    nom = None

  if cont < abnomal_length:
    abnom = abnomal[cont]
  else:
    abnom = None

  if cont < none_tracking_code_length:
    ntc = none_tracking_code[cont]
  else:
    ntc = None

  csv_write.append([nom, " ",  abnom, " ", ntc, " "])
  cont += 1


# csv書き込み
df = pd.DataFrame(csv_write, columns=["nomal", "", "abnomal", "", "none_tracking_code", ""])

domain = url.replace("https://www.", "")
domain = domain.replace("http://www.", "")
domain = domain.replace("http://", "")
domain = domain.replace("https://", "")
domain = domain.replace("/", "")

file = "/tmp/" + domain + ".csv"
df.to_csv(file, sep=",")
