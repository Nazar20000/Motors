// Global Search Functionality
function initializeGlobalSearch() {
  const searchIcon = document.querySelector(".search-icon")

  if (searchIcon) {
    searchIcon.addEventListener("click", () => {
      showSearchModal()
    })
  }

  // Keyboard shortcut for search (Ctrl/Cmd + K)
  document.addEventListener("keydown", (e) => {
    if ((e.ctrlKey || e.metaKey) && e.key === "k") {
      e.preventDefault()
      showSearchModal()
    }
  })
}

function showSearchModal() {
  // Remove existing search modal
  const existingModal = document.querySelector(".search-modal")
  if (existingModal) {
    existingModal.remove()
  }

  const modal = document.createElement("div")
  modal.className = "search-modal"
  modal.innerHTML = `
        <div class="search-modal-overlay"></div>
        <div class="search-modal-content">
            <div class="search-header">
                <h2>SEARCH INVENTORY</h2>
                <button class="search-close" aria-label="Close search">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <div class="search-form">
                <div class="search-input-container">
                    <input type="text" id="globalSearchInput" placeholder="Type a keyword to search" autocomplete="off">
                    <button class="voice-search-btn" aria-label="Voice search">
                        <span class="material-symbols-outlined">mic</span>
                    </button>
                    <button class="search-submit-btn" aria-label="Search">
                        <span class="material-symbols-outlined">search</span>
                    </button>
                </div>
                <div class="search-suggestions" id="searchSuggestions"></div>
                <div class="search-filters">
                    <div class="filter-group">
                        <label>Quick Filters:</label>
                        <div class="filter-buttons">
                            <button class="filter-btn" data-filter="make">Make</button>
                            <button class="filter-btn" data-filter="model">Model</button>
                            <button class="filter-btn" data-filter="year">Year</button>
                            <button class="filter-btn" data-filter="price">Price</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `

  document.body.appendChild(modal)

  // Add search modal styles
  addSearchModalStyles()

  // Show modal with animation
  setTimeout(() => {
    modal.classList.add("active")
    const searchInput = modal.querySelector("#globalSearchInput")
    searchInput.focus()
  }, 100)

  // Initialize search functionality
  initializeSearchModal(modal)
}

function addSearchModalStyles() {
  if (document.querySelector("#searchModalStyles")) return

  const styles = document.createElement("style")
  styles.id = "searchModalStyles"
  styles.textContent = `
        .search-modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 10000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        
        .search-modal.active {
            opacity: 1;
            visibility: visible;
        }
        
        .search-modal-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(5px);
        }
        
        .search-modal-content {
            position: relative;
            max-width: 600px;
            width: 90%;
            margin: 10vh auto 0;
            background: #1a1a1a;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            transform: translateY(-50px);
            transition: transform 0.3s ease;
        }
        
        .search-modal.active .search-modal-content {
            transform: translateY(0);
        }
        
        .search-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 25px 30px;
            border-bottom: 1px solid #333;
        }
        
        .search-header h2 {
            color: #ffffff;
            font-size: 20px;
            font-weight: bold;
            margin: 0;
        }
        
        .search-close {
            background: none;
            border: none;
            color: #cccccc;
            cursor: pointer;
            padding: 5px;
            border-radius: 50%;
            transition: all 0.3s ease;
        }
        
        .search-close:hover {
            background-color: #333;
            color: #ffffff;
        }
        
        .search-form {
            padding: 30px;
        }
        
        .search-input-container {
            position: relative;
            margin-bottom: 25px;
        }
        
        .search-input-container input {
            width: 100%;
            padding: 15px 60px 15px 20px;
            background-color: #2a2a2a;
            border: 2px solid #444;
            border-radius: 8px;
            color: #ffffff;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        
        .search-input-container input:focus {
            outline: none;
            border-color: #ffff00;
            box-shadow: 0 0 0 3px rgba(255, 255, 0, 0.1);
        }
        
        .search-input-container input::placeholder {
            color: #888;
        }
        
        .voice-search-btn,
        .search-submit-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #cccccc;
            cursor: pointer;
            padding: 8px;
            border-radius: 4px;
            transition: all 0.3s ease;
        }
        
        .voice-search-btn {
            right: 50px;
        }
        
        .search-submit-btn {
            right: 10px;
            background-color: #ffff00;
            color: #000;
        }
        
        .voice-search-btn:hover,
        .search-submit-btn:hover {
            background-color: #ffff00;
            color: #000;
        }
        
        .search-suggestions {
            max-height: 200px;
            overflow-y: auto;
            margin-bottom: 20px;
            border-radius: 8px;
            background-color: #2a2a2a;
            display: none;
        }
        
        .search-suggestions.active {
            display: block;
        }
        
        .suggestion-item {
            padding: 12px 20px;
            color: #cccccc;
            cursor: pointer;
            border-bottom: 1px solid #333;
            transition: background-color 0.3s ease;
        }
        
        .suggestion-item:hover,
        .suggestion-item.highlighted {
            background-color: #333;
            color: #ffffff;
        }
        
        .suggestion-item:last-child {
            border-bottom: none;
        }
        
        .search-filters {
            margin-top: 20px;
        }
        
        .filter-group label {
            color: #ffffff;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            display: block;
        }
        
        .filter-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        .filter-btn {
            background-color: #333;
            color: #cccccc;
            border: none;
            padding: 8px 16px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.3s ease;
        }
        
        .filter-btn:hover,
        .filter-btn.active {
            background-color: #ffff00;
            color: #000;
        }
        
        @media (max-width: 768px) {
            .search-modal-content {
                width: 95%;
                margin-top: 5vh;
            }
            
            .search-header {
                padding: 20px;
            }
            
            .search-form {
                padding: 20px;
            }
            
            .search-input-container input {
                padding: 12px 50px 12px 15px;
                font-size: 14px;
            }
            
            .voice-search-btn {
                right: 40px;
            }
        }
    `

  document.head.appendChild(styles)
}

function initializeSearchModal(modal) {
  const searchInput = modal.querySelector("#globalSearchInput")
  const searchSuggestions = modal.querySelector("#searchSuggestions")
  const closeBtn = modal.querySelector(".search-close")
  const overlay = modal.querySelector(".search-modal-overlay")
  const submitBtn = modal.querySelector(".search-submit-btn")
  const voiceBtn = modal.querySelector(".voice-search-btn")
  const filterBtns = modal.querySelectorAll(".filter-btn")

  // Sample search data (in real app, this would come from API)
  const searchData = [
    "Tesla Model 3",
    "BMW X5",
    "Mercedes C-Class",
    "Audi A4",
    "Porsche 911",
    "Lexus RX",
    "Honda Accord",
    "Toyota Camry",
    "Ford F-150",
    "Chevrolet Silverado",
    "2024",
    "2023",
    "2022",
    "2021",
    "SUV",
    "Sedan",
    "Truck",
    "Coupe",
  ]

  let currentSuggestionIndex = -1

  // Search input functionality
  searchInput.addEventListener("input", function () {
    const query = this.value.trim().toLowerCase()

    if (query.length > 0) {
      const suggestions = searchData.filter((item) => item.toLowerCase().includes(query)).slice(0, 8)

      if (suggestions.length > 0) {
        showSuggestions(suggestions, query)
      } else {
        hideSuggestions()
      }
    } else {
      hideSuggestions()
    }

    currentSuggestionIndex = -1
  })

  // Keyboard navigation
  searchInput.addEventListener("keydown", function (e) {
    const suggestions = searchSuggestions.querySelectorAll(".suggestion-item")

    if (e.key === "ArrowDown") {
      e.preventDefault()
      currentSuggestionIndex = Math.min(currentSuggestionIndex + 1, suggestions.length - 1)
      updateSuggestionHighlight(suggestions)
    } else if (e.key === "ArrowUp") {
      e.preventDefault()
      currentSuggestionIndex = Math.max(currentSuggestionIndex - 1, -1)
      updateSuggestionHighlight(suggestions)
    } else if (e.key === "Enter") {
      e.preventDefault()
      if (currentSuggestionIndex >= 0 && suggestions[currentSuggestionIndex]) {
        selectSuggestion(suggestions[currentSuggestionIndex].textContent)
      } else {
        performSearch(this.value)
      }
    } else if (e.key === "Escape") {
      closeSearchModal()
    }
  })

  function showSuggestions(suggestions, query) {
    searchSuggestions.innerHTML = suggestions
      .map((suggestion) => {
        const highlighted = suggestion.replace(
          new RegExp(`(${query})`, "gi"),
          '<strong style="color: #ffff00;">$1</strong>',
        )
        return `<div class="suggestion-item">${highlighted}</div>`
      })
      .join("")

    searchSuggestions.classList.add("active")

    // Add click handlers to suggestions
    searchSuggestions.querySelectorAll(".suggestion-item").forEach((item) => {
      item.addEventListener("click", function () {
        selectSuggestion(this.textContent)
      })
    })
  }

  function hideSuggestions() {
    searchSuggestions.classList.remove("active")
    currentSuggestionIndex = -1
  }

  function updateSuggestionHighlight(suggestions) {
    suggestions.forEach((item, index) => {
      item.classList.toggle("highlighted", index === currentSuggestionIndex)
    })

    if (currentSuggestionIndex >= 0) {
      searchInput.value = suggestions[currentSuggestionIndex].textContent
    }
  }

  function selectSuggestion(suggestion) {
    searchInput.value = suggestion
    hideSuggestions()
    performSearch(suggestion)
  }

  function performSearch(query) {
    if (!query.trim()) return

    // Close modal
    closeSearchModal()

    // Redirect to inventory page with search parameters
    const searchParams = new URLSearchParams()
    searchParams.set("search", query.trim())

    // Add active filters
    const activeFilters = modal.querySelectorAll(".filter-btn.active")
    activeFilters.forEach((filter) => {
      searchParams.set("filter", filter.dataset.filter)
    })

    window.location.href = `inventory.html?${searchParams.toString()}`
  }

  // Submit button
  submitBtn.addEventListener("click", () => {
    performSearch(searchInput.value)
  })

  // Voice search (placeholder functionality)
  voiceBtn.addEventListener("click", function () {
    if ("webkitSpeechRecognition" in window || "SpeechRecognition" in window) {
      const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition
      const recognition = new SpeechRecognition()

      recognition.continuous = false
      recognition.interimResults = false
      recognition.lang = "en-US"

      this.style.color = "#ff4444"
      this.innerHTML = '<span class="material-symbols-outlined">mic</span>'

      recognition.onresult = (event) => {
        const transcript = event.results[0][0].transcript
        searchInput.value = transcript
        searchInput.dispatchEvent(new Event("input"))
      }

      recognition.onerror = () => {
        console.error("Voice search not available")
      }

      recognition.onend = () => {
        voiceBtn.style.color = "#cccccc"
      }

      recognition.start()
    } else {
      console.warn("Voice search not supported in this browser")
    }
  })

  // Filter buttons
  filterBtns.forEach((btn) => {
    btn.addEventListener("click", function () {
      this.classList.toggle("active")
    })
  })

  // Close modal functionality
  function closeSearchModal() {
    modal.classList.remove("active")
    setTimeout(() => {
      modal.remove()
    }, 300)
  }

  closeBtn.addEventListener("click", closeSearchModal)
  overlay.addEventListener("click", closeSearchModal)

  // Close on Escape key
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && modal.classList.contains("active")) {
      closeSearchModal()
    }
  })
}

// Initialize global search when DOM is loaded
document.addEventListener("DOMContentLoaded", () => {
  initializeGlobalSearch()
})

// Function to show notifications
function showNotification(message, type) {
  console.log(`Notification (${type}): ${message}`)
}
