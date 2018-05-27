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

sys.setrecursionlimit(100000)
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


def appned(log, source, gatag_exist, script):
  code = tracking_code
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
    script_tag_exist = 0
    for scr in script:
      script_driver.get(scr)
      script_source = script_driver.page_source
      script_tag_exist = code in script_source
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


def get_attribute(new_list, row_list, attribute):
  for cont in row_list:
    if cont.get_attribute(attribute):
      new_list.append(cont.get_attribute(attribute))


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
            scripts = []
            get_attribute(scripts, row_scripts, "src")

            # 各配列に格納
            appned(log, source, gatag_exist, scripts)


            # urlをキーに、linkの中のaタグを格納
            row_content = []
            row_content = inner_driver.find_elements_by_tag_name("a")

            #row_contentの中身をcontentに格納
            get_attribute(content, row_content, "href")

            inner_driver.quit()

  print("--page end--")
  return content

# ドライバの起動
driver = webdriver.PhantomJS(service_log_path = log_name, desired_capabilities = dcap, service_args=phantomjs_options)
driver.set_window_size(1024, 768)
print("start")


# linksにトップurlのaタグを格納
driver.get(str(url))
driver.set_page_load_timeout(5)
row_links = driver.find_elements_by_tag_name("a")

# console, ソース, gaタグの有無を取得
log = driver.get_log("browser")
source = driver.page_source
gatag_exist = tracking_code in source

# 外部jsファイルを読んでinner_scriptに格納
row_scripts = driver.find_elements_by_tag_name("script")
scripts = []
get_attribute(scripts, row_scripts, "src")

# 各配列に格納
appned(log, source, gatag_exist, scripts)

# linksにurlを格納
links = []
get_attribute(links, row_links, "href")

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
