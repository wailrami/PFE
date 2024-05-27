


import Dropzone from 'dropzone';

document.addEventListener('DOMContentLoaded', () => {
  var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
  Dropzone.autoDiscover = false;
  const myDropzone = new Dropzone('#myDropzone', { 
      // Dropzone options
      url: '/upload', // Set the url for your upload script
      method: 'post', // Set the form method
      maxFilesize: 5, // Maximum file size in MB
      paramName: 'images', // The name that will be used to transfer the file
      acceptedFiles: 'image/*', // Accepted file types
      uploadMultiple: true, // Set to true to allow multiple file uploads
      dictDefaultMessage: 'Drop files here or click to upload.', // Default message
      addRemoveLinks: true, // Add remove links to preview images
      dictRemoveFile: 'Remove', // Remove file text
      init: function() {
        this.on("sending", function(file, xhr, formData) {
          formData.append("_token", CSRF_TOKEN);
        }); 
        this.on('drop', function() {
          // When files are dropped, trigger an AJAX request to the upload endpoint
          console.log('Files dropped:', this.files);
          this.processQueue();
        });
        this.on('error', function(file, errorMessage, xhr) {
            console.log('File upload error:', file, errorMessage, xhr);
        });
        this.on('success', function(file, response) {
            console.log('File uploaded successfully:', file, response);
            //file.previewElement.classList.remove('dz-image-preview');
        });
        this.on('addedfile', function(file) {
          
          file.previewElement.animate([
              { opacity: '0' },
              { opacity: '1' }
          ], {
              duration: 500,
              easing: 'ease-in-out'
          });
          const previewElement = file.previewElement;
          const removeButton = previewElement.querySelector('.dz-remove');
          if (removeButton) {
              removeButton.classList.add('text-red-500');
              removeButton.classList.add('dark:bg-gray-800');
          }
          const dzImage = previewElement.querySelector('.dz-details');
          console.log(dzImage);
          if (dzImage) {
            console.log("dzImage");
              dzImage.classList.add('transition-opacity');
              dzImage.classList.add('duration-200');
          }
          file.previewElement.classList.add('dark:bg-gray-800');
      });
      this.on('complete', function(file) {
        file.previewElement.classList.remove('dz-image-preview');
      });
    }

  });
});
