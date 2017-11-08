Language Model Bahasa Indonesia

Program ini merupakan program training language model menggunakan teknik N-Gram, bigram probability checker dan generator kalimat otomatis berdasarkan kata awal maupun secara random.
Corpus yang digunakan dikumpulkan dari beberapa situs berbahasa Indonesia, didapat dari (LINK)


Cara penggunaan :
1. Clone repository ini menggunakan Git
	command : git clone https://github.com/ahmadzainala/nlp_ngram.git
	
2. Ubah config base_url pada applocation/config/config > base_url tempat menyimpan di htdocs

3. Gunakan apache / xampp, kemudian buka localhost/apache anda di url browser. Contoh : http://localhost/nlp_ngram/index.php


a. Mencari tahu probabilitas suatu bigram
   - Pada segmen form "Cek Probabilitas Bigram", masukkan kata pertama dan kata kedua yang ingin dicari 
     probabilitasnya, kemudian hasil yang diinginkan akan tampil pada section "Hasil" di sebelah kanan.

b. Generate kalimat berdasarkan kata pertama
   - Input kata pertama dan jumlah kalimat yang diinginkan pada segmen form "Generator Kalimat". Hasilnya       akan muncul di section sebelah kanan.

c. Cek 10 besar n-gram : masukkan n yang diinginkan pada field di segmen form "Cek 10 Besar N-Gram"

d. Generator Kalimat Random : klik tombol Generate, hasilnya akan dapat dilihat pada section "Hasil" di sebelah kanan.


Note : 
- Tidak bisa menggunakan semua segmen form dalam sekali waktu.
- Gunakan data yang lebih variatif dan lebih banyak untuk menyempurnakan generator kalimat.