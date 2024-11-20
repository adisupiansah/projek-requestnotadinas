document.getElementById('showFormButton').addEventListener('click', function () {
    const formContainer = document.getElementById('formContainer');
    const showFormButton = document.getElementById('showFormButton');

    if (!formContainer.classList.contains('show')) {
      formContainer.classList.add('show'); // Tambahkan animasi
      showFormButton.style.display = 'none'; // Sembunyikan tombol
    }
  });

