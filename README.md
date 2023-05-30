Autor: Maciej Włodarczak (eskim.pl)
wersja: 1.0
Na podstawie artykułu: https://eskim.pl/web-scrapping-w-php/

Skrypt pobiera dane z serwisu lotto.pl od początku istnienia. Wyniki zapisuje w bazie SQLite.

- duży lotek
- duży lotek plus
- multi lotek
- multi lotek plus
- ekstra pensja
- ekstra pensja ekstra premia
- kaskada
- mini lotto
- euro jackpot

Udostępniona jest baza danych z wynikami do dnia 30.05.2023 (po południu) lub późniejszymi.

-- KONFIGURACJA --

Ustawienia skryptu znajdują się w pliku config.php
Nie ma problemu, aby dodać tam również obsługę np. Keno, ale ze względu na dużą ilość rekordów będzie się to pobierało bardzo długo.

W ustawieniach podajemy:
- nazwę bazy danych
- tabelę w bazie danych (table)
- kawałek linka w serwisie lotto.pl, który wskazuje na rodzaj gry
- ilość liczb, któe zostaną zapisane

Dostępne są również ustawienia takie jak table2 czy count2, a to dlatego że niektóre wyniki w serwisie pokazują jednocześnie dwa różne losowania np. lotto i lotto plus. Chcemy to zapisać za jednym parsowaniem.

-- ODPOWIEDZIALNOŚĆ --

Proces pozyskiwania danych z serwisu opiera się na Web Scrapping-u i może być uznawany za szkodliwy przez niektóre serwisy od których pobieramy dane.
Autor nie ponosi żadnej odpowiedzialności z tytułu błędów w skrypcie, albo niewłaściwego jego wykorzystania.

Korzystasz na własną odpowiedzialność.
