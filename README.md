# perpus
API File = API E-PERPUS
RANCANGAN ERD = erd e-perpus.pdf

Login Admin: 
  email: dev.miptha@gmail.com
  password: admin123
Login Anggota:
  email: anggota@gmail.com
  password: 12345678
Database:
  perpus.sql
  
API E-PERPUS
a.Mengambil data semua buku : http://127.0.0.1:8000/api/books
b.Mengambil data buku sesuai dengan kode: http://127.0.0.1:8000/api/books/{code}
c.Membuat buku baru: http://127.0.0.1:8000/api/addBooks
d.Mengubah data buku sesuai dengan kode: http://127.0.0.1:8000/api/updateBooks
e.Menghapus data buku sesuai dengan kode: http://127.0.0.1:8000/api/deleteBooks
