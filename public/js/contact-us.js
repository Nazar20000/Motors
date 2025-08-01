// Contact Us page functionality
document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("contactForm")
  const submitBtn = form.querySelector(".submit-btn")
  const btnText = submitBtn.querySelector(".btn-text")
  const btnLoading = submitBtn.querySelector(".btn-loading")

  // Phone number formatting
  const phoneInput = document.getElementById("phone")
  phoneInput.addEventListener("input", function () {
    let value = this.value.replace(/\D/g, "")
    if (value.length >= 6) {
      value = value.replace(/(\d{3})(\d{3})(\d{4})/, "($1) $2-$3")
    } else if (value.length >= 3) {
      value = value.replace(/(\d{3})(\d{0,3})/, "($1) $2")
    }
    this.value = value
  })

  // Character count for message
  const messageTextarea = document.getElementById("message")
  const messageCount = document.getElementById("messageCount")
  const maxLength = 1024

  messageTextarea.addEventListener("input", function () {
    const currentLength = this.value.length
    messageCount.textContent = currentLength

    const countContainer = messageCount.parentElement
    countContainer.classList.remove("warning", "error")

    if (currentLength > maxLength * 0.9) {
      countContainer.classList.add("warning")
    }
    if (currentLength > maxLength) {
      countContainer.classList.add("error")
      this.value = this.value.substring(0, maxLength)
      messageCount.textContent = maxLength
    }
  })

  // Real-time validation
  const requiredFields = form.querySelectorAll("[required]")
  requiredFields.forEach((field) => {
    field.addEventListener("blur", function () {
      validateField(this)
    })

    field.addEventListener("input", function () {
      if (this.classList.contains("error")) {
        validateField(this)
      }
    })
  })

  function validateField(field) {
    const formGroup = field.closest(".form-group")
    const existingError = formGroup.querySelector(".error-message")
    const existingSuccess = formGroup.querySelector(".success-message")

    // Remove existing messages
    if (existingError) existingError.remove()
    if (existingSuccess) existingSuccess.remove()
    formGroup.classList.remove("error", "success")

    let isValid = true
    let errorMessage = ""

    // Check if field is empty
    if (field.hasAttribute("required") && !field.value.trim()) {
      isValid = false
      errorMessage = "This field is required"
    }

    // Email validation
    if (field.type === "email" && field.value) {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
      if (!emailRegex.test(field.value)) {
        isValid = false
        errorMessage = "Please enter a valid email address"
      }
    }

    // Phone validation
    if (field.type === "tel" && field.value) {
      const phoneRegex = /^$$\d{3}$$ \d{3}-\d{4}$/
      if (!phoneRegex.test(field.value)) {
        isValid = false
        errorMessage = "Please enter a valid phone number"
      }
    }

    // Display validation result
    if (!isValid) {
      formGroup.classList.add("error")
      const errorDiv = document.createElement("div")
      errorDiv.className = "error-message"
      errorDiv.innerHTML = `<span class="material-symbols-outlined">error</span>${errorMessage}`
      formGroup.appendChild(errorDiv)
    } else if (field.value.trim()) {
      formGroup.classList.add("success")
      const successDiv = document.createElement("div")
      successDiv.className = "success-message"
      successDiv.innerHTML = `<span class="material-symbols-outlined">check_circle</span>Valid`
      formGroup.appendChild(successDiv)
    }

    return isValid
  }

  // Contact preference validation
  function validateContactPreferences() {
    const preferences = form.querySelectorAll('input[name="contactPreference"]:checked')
    if (preferences.length === 0) {
      showNotification("Please select at least one contact preference", "warning")
      return false
    }
    return true
  }

  // Form submission
  form.addEventListener("submit", (e) => {
    e.preventDefault()

    // Validate all required fields
    let isFormValid = true
    requiredFields.forEach((field) => {
      if (!validateField(field)) {
        isFormValid = false
      }
    })

    // Validate contact preferences
    if (!validateContactPreferences()) {
      isFormValid = false
    }

    // Check terms acceptance
    const termsCheckbox = document.getElementById("acceptTerms")
    if (!termsCheckbox.checked) {
      isFormValid = false
      showNotification("Please accept the terms and conditions", "error")
    }

    if (!isFormValid) {
      showNotification("Please correct the errors in the form", "error")
      // Scroll to first error
      const firstError = form.querySelector(".form-group.error")
      if (firstError) {
        firstError.scrollIntoView({ behavior: "smooth", block: "center" })
      }
      return
    }

    // Show loading state
    submitBtn.disabled = true
    btnText.style.display = "none"
    btnLoading.style.display = "flex"

    // Simulate form submission
    setTimeout(() => {
      // Reset button state
      submitBtn.disabled = false
      btnText.style.display = "inline"
      btnLoading.style.display = "none"

      // Show success modal
      showSuccessModal()

      // Reset form
      form.reset()
      messageCount.textContent = "0"

      // Remove validation classes
      const validatedGroups = form.querySelectorAll(".form-group.error, .form-group.success")
      validatedGroups.forEach((group) => {
        group.classList.remove("error", "success")
        const messages = group.querySelectorAll(".error-message, .success-message")
        messages.forEach((msg) => msg.remove())
      })
    }, 2000)
  })

  function showSuccessModal() {
    const modal = document.createElement("div")
    modal.className = "success-modal"
    modal.innerHTML = `
            <div class="success-modal-content">
                <div class="success-icon">
                    <span class="material-symbols-outlined">check_circle</span>
                </div>
                <h2>Message Sent Successfully!</h2>
                <p>Thank you for contacting us! We have received your message and will get back to you within 24 hours using your preferred contact method.</p>
                <button onclick="this.closest('.success-modal').remove()">Close</button>
            </div>
        `

    document.body.appendChild(modal)

    // Show modal with animation
    setTimeout(() => {
      modal.classList.add("active")
    }, 100)

    // Auto close after 5 seconds
    setTimeout(() => {
      if (modal.parentElement) {
        modal.classList.remove("active")
        setTimeout(() => {
          modal.remove()
        }, 300)
      }
    }, 5000)

    // Close on backdrop click
    modal.addEventListener("click", (e) => {
      if (e.target === modal) {
        modal.classList.remove("active")
        setTimeout(() => {
          modal.remove()
        }, 300)
      }
    })
  }

  function showNotification(message, type = "info") {
    // Remove existing notifications
    const existingNotifications = document.querySelectorAll(".notification")
    existingNotifications.forEach((notification) => notification.remove())

    const notification = document.createElement("div")
    notification.className = `notification notification-${type}`
    notification.innerHTML = `
            <span class="material-symbols-outlined">
                ${
                  type === "success"
                    ? "check_circle"
                    : type === "warning"
                      ? "warning"
                      : type === "error"
                        ? "error"
                        : "info"
                }
            </span>
            <span>${message}</span>
        `

    // Add notification styles
    notification.style.cssText = `
            position: fixed;
            top: 100px;
            right: 20px;
            background: ${
              type === "success" ? "#4CAF50" : type === "warning" ? "#FF9800" : type === "error" ? "#F44336" : "#2196F3"
            };
            color: white;
            padding: 15px 20px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 10000;
            animation: slideIn 0.3s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            max-width: 400px;
        `

    document.body.appendChild(notification)

    setTimeout(() => {
      notification.style.animation = "slideOut 0.3s ease"
      setTimeout(() => {
        notification.remove()
      }, 300)
    }, 4000)
  }

  // Enhanced contact links
  const contactLinks = document.querySelectorAll(".contact-link")
  contactLinks.forEach((link) => {
    link.addEventListener("click", function (e) {
      const href = this.getAttribute("href")
      if (href.startsWith("tel:")) {
        // Analytics for phone clicks
        console.log("Phone number clicked:", href)
      } else if (href.startsWith("mailto:")) {
        // Analytics for email clicks
        console.log("Email clicked:", href)
      }
    })
  })

  // Map interaction
  const mapFrame = document.querySelector("iframe")
  if (mapFrame) {
    mapFrame.addEventListener("load", () => {
      console.log("Map loaded successfully")
    })

    mapFrame.addEventListener("error", function () {
      console.error("Map failed to load")
      const mapContainer = this.parentElement
      mapContainer.innerHTML = `
                <div style="height: 400px; background: #333; display: flex; align-items: center; justify-content: center; color: #fff; border-radius: 12px;">
                    <div style="text-align: center;">
                        <span class="material-symbols-outlined" style="font-size: 48px; margin-bottom: 10px;">location_off</span>
                        <p>Map temporarily unavailable</p>
                        <p style="font-size: 12px; color: #ccc;">Please use the address above for directions</p>
                    </div>
                </div>
            `
    })
  }

  // Auto-save functionality (optional)
  let autoSaveTimeout
  const formInputs = form.querySelectorAll("input, textarea")

  formInputs.forEach((input) => {
    input.addEventListener("input", () => {
      clearTimeout(autoSaveTimeout)
      autoSaveTimeout = setTimeout(() => {
        saveFormData()
      }, 1000)
    })
  })

  function saveFormData() {
    const formData = new FormData(form)
    const data = {}
    for (const [key, value] of formData.entries()) {
      if (data[key]) {
        // Handle multiple values (like checkboxes)
        if (Array.isArray(data[key])) {
          data[key].push(value)
        } else {
          data[key] = [data[key], value]
        }
      } else {
        data[key] = value
      }
    }
    localStorage.setItem("contactFormData", JSON.stringify(data))
  }

  function loadFormData() {
    const savedData = localStorage.getItem("contactFormData")
    if (savedData) {
      const data = JSON.parse(savedData)
      Object.keys(data).forEach((key) => {
        const field = form.querySelector(`[name="${key}"]`)
        if (field && data[key]) {
          if (field.type === "checkbox") {
            if (Array.isArray(data[key])) {
              data[key].forEach((value) => {
                const checkbox = form.querySelector(`[name="${key}"][value="${value}"]`)
                if (checkbox) checkbox.checked = true
              })
            } else {
              field.checked = data[key] === field.value
            }
          } else {
            field.value = data[key]
          }
        }
      })

      // Update character count if message was loaded
      if (data.message) {
        messageCount.textContent = data.message.length
      }
    }
  }

  // Load saved data on page load
  loadFormData()

  // Clear saved data on successful submission
  form.addEventListener("submit", () => {
    setTimeout(() => {
      localStorage.removeItem("contactFormData")
    }, 2000)
  })

  console.log("Contact Us page - All scripts loaded successfully")
})
