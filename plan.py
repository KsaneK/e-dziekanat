# -*- coding: utf-8 -*-
import requests
import codecs
from bs4 import BeautifulSoup as bs
from requests.packages.urllib3.exceptions import InsecureRequestWarning
from time import sleep
import json
import datetime
from sys import exit

requests.packages.urllib3.disable_warnings(InsecureRequestWarning)
URL = "https://s1.wcy.wat.edu.pl/ed/"

class eDziekanat:
    def __init__(self, login, passwd, output):
        self.timetable = {}
        self.output_dir = output
        # parametry formularza logowania
        self.params = {
            "default_fun": 1,
            "formname": "login",
            "userid": login,
            "password": passwd
            }
        # utworzenie sesji
        self.session = requests.session()
    def login(self):
        """Funkcja najpierw getem pobiera id sesji, a po tym wysyła posta z danymi logowania"""
        response = self.session.get(URL, verify=False)
        response.encoding = "utf-8"
        soup = bs(response.text, 'html.parser')
        self.login_form = soup.find("form")
        self.ssid = self.login_form.attrs['action'].replace('index.php?sid=', '')

        # czasami e-dziekanat jest przeciążony lub nie działa
        # w takim wypadku strona nie generuje nam id sesji
        if not self.ssid:
            print("Nie udało się uzyskać ssid.\nKończenie programu")
            exit()

        print("SSID: %s" % self.ssid)
        self.session.post(
            "%s%s" % (URL, self.login_form.attrs['action']),
            data = self.params,
            verify = False
        )

if __name__ == "__main__":
    with open("dane.txt", "r") as f:
        username = f.readline().replace("\n","").replace("\r","").split("=")[1]
        password = f.readline().replace("\n","").replace("\r","").split("=")[1]
        output = f.readline().replace("\n","").replace("\r","").split("=")[1]
        groups = f.readline().replace("\n","").replace("\r","").split("=")[1]
        groups = groups.split(",")
    ed = eDziekanat(username, password, output)
    ed.login()
