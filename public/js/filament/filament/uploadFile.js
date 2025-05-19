
// UPLOAD DE LA PHOTO DE L'ETUDIANT
const photoInput = document.getElementById('photoInput');
  const previewContainer = document.getElementById('previewContainer');

  photoInput.addEventListener('change', (e) => {
    const file = e.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = (event) => {
      previewContainer.innerHTML = `<img src="${event.target.result}" alt="Preview" class="object-cover w-full h-full" />`;
    };
    reader.readAsDataURL(file);
});