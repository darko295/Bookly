# Bookly

*Potrebno je importovati fajl iz foldera db u okviru phpMyAdmin-a.*

**Da bi slanje mejla funkcionisalo potrebno je uraditi sledece:

1. Fajl sendmail.ini kopirati u C:\xampp\sendmail i zameniti ga postojecim, fajl php.ini kopirati u C:\xampp\php i zameniti ga postojecim
    **(fajlovi se nalaze u folderu MAIL)

2. Prilikom svakog pokretanja xampp servera to uciniti desnim klikom -> Run as administrator

3. Desni klik na sendmail.exe fajl  (iz C:\xampp\sendmail) -> Properties -> Compatibility tab
    - U Compatibility mode oznaciti check box i izabrati Windows XP (Service pack 3) iz combo box-a
    - U Setting delu oznaciti Run this program as an administrator
 -> Apply -> Close

**Obavezno uraditi import nove baze jer sadrzi nove tabele.
