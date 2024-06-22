


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
        removedfile: function(file) {
            if (!file.upload || !file.upload.filename) {
              return;
            }
            // Remove file from server with AJAX request
            console.log(file);
            var name = file.upload.filename;
            fetch('/delete', {
              method: 'DELETE',
              headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': CSRF_TOKEN,
              },
              body: JSON.stringify({ filename: name })
            })
            .then(response => response.json())
            .then(data => console.log(data))
            .catch(error => console.error('Error:', error)); 
            var _ref;
            console.log(name);
            return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
        },
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
              file.upload.filename = response.filenames.find(name => name === file.name); // Store filename for later removal
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
    window.addEventListener('beforeunload', function() {
      navigator.sendBeacon('/clear-uploaded-files', new URLSearchParams({
        '_token': CSRF_TOKEN
      }));
    });
  });

