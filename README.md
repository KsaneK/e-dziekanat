# Plan zajęć - e-Dziekanat
## Jak to działa?
Skrypt loguje się do systemu e-Dziekanat danymi zapisanymi w pliku dane.txt, a następnie pobiera plan zajęć wybranych grup. Plan zostaje przetworzony i zapisany w pliku nazwa_grupy.json
## Wymagania
#### [Python 3](https://www.python.org/downloads/)  
### Biblioteki:  
#### Requests  
##### ``` pip3 install requests ```  
#### BeautifulSoup4  
##### ``` pip3 install beautifulsoup4 ```

## Jak uruchomić?
W pliku dane.txt wpisz swoje dane logowania do systemu e-Dziekanat.

Plik powinien mieć następującą strukturę:
```
username=TWÓJ LOGIN
password=TWOJE HASŁO
output=ŚCIEŻKA DO KATALOGU W KTÓRYM BĘDĄ ZAPISYWANE PLIKI
grupy=NAZWY,GRUP,ODDZIELONE,PRZECINKAMI
```
Przykładowy plik:
```
username=Kowalski
password=tajne
output=/var/www/html
grupy=I6Y1S1,I6Y2S1,I6Y4S1,I6X5S1,K6X2S1,H6X2S1
```
Mając wypełniony ten plik możemy uruchomić skrypt poleceniem:  
#### ``` python3 plan.py ```
