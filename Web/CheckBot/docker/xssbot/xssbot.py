import requests
from selenium import webdriver
from selenium.webdriver.chrome.options import Options
import time,os,base64
import thread


chrome_opt = Options()
chrome_opt.binary_location = '/usr/bin/google-chrome-stable'
chrome_opt.add_argument('--headless')
chrome_opt.add_argument('--disable-gpu')
chrome_opt.add_argument('--window-size=1366,768')
chrome_opt.add_argument("--no-sandbox")
chrome_opt.add_argument("--disable-web-security")

# Modification
def req(turl):
    try:
      browser = webdriver.Chrome(
                executable_path='/var/xssbot/chromedriver', chrome_options=chrome_opt)
      browser.get(turl)
      browser.set_page_load_timeout(5)
      browser.set_script_timeout(5)
    except Exception as e:
      browser.quit()
      pass
    finally:
      browser.quit()

def get_url():
    path="/nobodys3cr3t"
    filelist=os.listdir(path)
    if filelist:
        filep = filelist[0]
        os.remove(os.path.join(path,filep))
    else:
        filep = ""
    return filep

def get_url2():
    path="/nobodys3cr3t"
    filelist=os.listdir(path)
    print(filelist)
    for files in filelist:
        Olddir=os.path.join(path,files)
        if os.path.isdir(Olddir):
            continue
        filep=path+'/'+files
        if('index.html' in filep):
            continue
	if os.path.exists(filep):
	    os.remove(filep)
        time.sleep(2)
        return filep
def main():
  turl = get_url()
  if turl:
     print(turl)
     missing_padding = 4 - len(turl) % 4
     if missing_padding:
         turl += b'='*missing_padding
     turl = base64.b64decode(turl).encode().decode()
     print(turl)
     f=open("xssbot.log","a+")
     f.write("REQ: "+turl+"\n")
     f.close()
     req(turl)
while 1:
    try:
        main()
        continue
    except Exception as e:
        print(e)
        break
