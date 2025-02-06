<template>
  <div class="contact-form">
    <h2>Contact Us</h2>
    <form @submit.prevent="submitForm" enctype="multipart/form-data" novalidate>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="name" class="form-label">Name (2-10 characters)</label>
          <input 
            type="text" 
            class="form-control" 
            id="name" 
            v-model="form.name" 
            :class="{ 'is-invalid': submitted && !isNameValid }"
            @blur="validateField('name')"
          >
          <div v-if="submitted && !isNameValid" class="invalid-feedback">
            Name must be between 2 and 10 characters
          </div>
        </div>

        <div class="col-md-6 mb-3">
          <label for="email" class="form-label">Email (No Gmail)</label>
          <input 
            type="email" 
            class="form-control" 
            id="email" 
            v-model="form.email"
            :class="{ 'is-invalid': submitted && !isEmailValid }"
            @blur="validateField('email')"
          >
          <div v-if="submitted && !isEmailValid" class="invalid-feedback">
            Please use a non-Gmail email with a valid domain
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="phone" class="form-label">Phone (with prefix)</label>
          <input 
            type="tel" 
            class="form-control" 
            id="phone" 
            v-model="form.phone"
            :class="{ 'is-invalid': submitted && !isPhoneValid }"
            placeholder="+1 (123) 456-7890"
            @blur="validateField('phone')"
          >
          <div v-if="submitted && !isPhoneValid" class="invalid-feedback">
            Invalid phone number. Must start with a valid country code
          </div>
        </div>

        <div class="col-md-6 mb-3">
          <label for="message" class="form-label">Message (Min 10 characters)</label>
          <textarea 
            class="form-control" 
            id="message" 
            v-model="form.message"
            :class="{ 'is-invalid': submitted && !isMessageValid }"
            @blur="validateField('message')"
          ></textarea>
          <div v-if="submitted && !isMessageValid" class="invalid-feedback">
            Message must be at least 10 characters
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-4 mb-3">
          <label for="street" class="form-label">Street</label>
          <input 
            type="text" 
            class="form-control" 
            id="street" 
            v-model="form.street"
            :class="{ 'is-invalid': submitted && !isStreetValid }"
            @blur="validateField('street')"
          >
          <div v-if="submitted && !isStreetValid" class="invalid-feedback">
            Street is required
          </div>
        </div>

        <div class="col-md-4 mb-3">
          <label for="state" class="form-label">State</label>
          <input 
            type="text" 
            class="form-control" 
            id="state" 
            v-model="form.state"
            :class="{ 'is-invalid': submitted && !isStateValid }"
            @blur="validateField('state')"
          >
          <div v-if="submitted && !isStateValid" class="invalid-feedback">
            State is required
          </div>
        </div>

        <div class="col-md-4 mb-3">
          <label for="zip" class="form-label">Zip Code</label>
          <input 
            type="text" 
            class="form-control" 
            id="zip" 
            v-model="form.zip"
            :class="{ 'is-invalid': submitted && !isZipValid }"
            @blur="validateField('zip')"
          >
          <div v-if="submitted && !isZipValid" class="invalid-feedback">
            Zip code is required
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="country" class="form-label">Country</label>
          <input 
            type="text" 
            class="form-control" 
            id="country" 
            v-model="form.country"
            :class="{ 'is-invalid': submitted && !isCountryValid }"
            @blur="validateField('country')"
          >
          <div v-if="submitted && !isCountryValid" class="invalid-feedback">
            Country is required
          </div>
        </div>

        <div class="col-md-6 mb-3">
          <label for="images" class="form-label">Images (JPG only)</label>
          <input 
            type="file" 
            class="form-control" 
            id="images" 
            @change="handleImageUpload"
            accept=".jpg,.jpeg"
            multiple
          >
          <div v-if="submitted && !areImagesValid" class="invalid-feedback">
            Only JPG images are allowed
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12 mb-3">
          <label for="files" class="form-label">Files (PDF only)</label>
          <input 
            type="file" 
            class="form-control" 
            id="files" 
            @change="handleFileUpload"
            accept=".pdf"
            multiple
          >
          <div v-if="submitted && !areFilesValid" class="invalid-feedback">
            Only PDF files are allowed
          </div>
        </div>
      </div>

      <button 
        type="submit" 
        class="btn btn-primary"
      >
        Submit
      </button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      form: {
        name: '',
        email: '',
        phone: '',
        message: '',
        street: '',
        state: '',
        zip: '',
        country: '',
        images: [],
        files: []
      },
      submitted: false,
      errors: {}
    }
  },
  computed: {
    isNameValid() {
      return this.form.name.length >= 2 && this.form.name.length <= 10
    },
    isEmailValid() {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
      return emailRegex.test(this.form.email) && 
             !this.form.email.includes('@gmail.com')
    },
    isPhoneValid() {
      const phoneRegex = /^\+\d{1,3}\s?\(\d{3}\)\s?\d{3}[-.]?\d{4}$/
      return phoneRegex.test(this.form.phone)
    },
    isMessageValid() {
      return this.form.message.length >= 10
    },
    isStreetValid() {
      return !!this.form.street.trim()
    },
    isStateValid() {
      return !!this.form.state.trim()
    },
    isZipValid() {
      return !!this.form.zip.trim()
    },
    isCountryValid() {
      return !!this.form.country.trim()
    },
    areImagesValid() {
      return this.form.images.length === 0 || 
             this.form.images.every(file => 
               file.type.startsWith('image/jpeg')
             )
    },
    areFilesValid() {
      return this.form.files.length === 0 || 
             this.form.files.every(file => 
               file.type === 'application/pdf'
             )
    },
    isFormValid() {
      return this.isNameValid && 
             this.isEmailValid && 
             this.isPhoneValid && 
             this.isMessageValid &&
             this.isStreetValid &&
             this.isStateValid &&
             this.isZipValid &&
             this.isCountryValid &&
             this.areImagesValid &&
             this.areFilesValid
    }
  },
  methods: {
    validateField(field) {
      // Optional: Add any specific field validation logic here
      return true
    },
    handleImageUpload(event) {
      this.form.images = Array.from(event.target.files).filter(
        file => file.type.startsWith('image/jpeg')
      )
    },
    handleFileUpload(event) {
      this.form.files = Array.from(event.target.files).filter(
        file => file.type === 'application/pdf'
      )
    },
    submitForm() {
      // Mark form as submitted to show validation errors
      this.submitted = true

      // Validate entire form
      if (!this.isFormValid) {
        // Prevent submission if form is invalid
        return
      }

      // Prepare form data
      const formData = new FormData()
      
      // Append form fields
      Object.keys(this.form).forEach(key => {
        if (key !== 'images' && key !== 'files') {
          formData.append(key, this.form[key])
        }
      })

      // Append files
      this.form.images.forEach((file, index) => {
        formData.append(`images[${index}]`, file)
      })
      this.form.files.forEach((file, index) => {
        formData.append(`files[${index}]`, file)
      })

      // Submit form via axios
      axios.post('/submit-contact-form', formData, {
        headers: { 'Content-Type': 'multipart/form-data' }
      })
      .then(response => {
        // Success handling
        this.$swal.fire({
          icon: 'success',
          title: 'Form Submitted',
          text: 'Your message has been sent successfully!'
        })
        this.resetForm()
      })
      .catch(error => {
        // Error handling
        if (error.response && error.response.data.errors) {
          // Display validation errors from backend
          const errors = error.response.data.errors
          let errorMessage = 'Submission failed:\n'
          Object.values(errors).forEach(errorArray => {
            errorArray.forEach(msg => {
              errorMessage += `- ${msg}\n`
            })
          })
          
          this.$swal.fire({
            icon: 'error',
            title: 'Submission Error',
            text: errorMessage
          })
        } else {
          this.$swal.fire({
            icon: 'error',
            title: 'Unexpected Error',
            text: 'An unexpected error occurred. Please try again.'
          })
        }
      })
    },
    resetForm() {
      // Reset form data
      this.form = {
        name: '',
        email: '',
        phone: '',
        message: '',
        street: '',
        state: '',
        zip: '',
        country: '',
        images: [],
        files: []
      }
      
      // Reset validation state
      this.submitted = false
      
      // Reset file inputs
      const imageInput = document.getElementById('images')
      const filesInput = document.getElementById('files')
      if (imageInput) imageInput.value = ''
      if (filesInput) filesInput.value = ''
    }
  }
}
</script>

<style scoped>
.contact-form {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
}
.form-control.is-invalid {
  border-color: #dc3545;
}
.invalid-feedback {
  display: block;
  width: 100%;
  margin-top: 0.25rem;
  font-size: 80%;
  color: #dc3545;
}
</style>