<template>
<div>
 <!-- Search Input Group -->
 <div>

  <div class="container input-group pb-3" style="position: relative; width: 100%;">
   <input type="text" @keyup="debouncedSearch" v-model="searchTerm" placeholder="Explore the Quran..." class="form-control mr-3 pb-2 mobile-only" style="flex: 1;box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;"/>

   <!-- Suggestions Dropdown -->
   <ul v-if="suggestions.length" class="list-group suggestions" style="position: absolute; top: 100%; left: 0; width: 95%; z-index: 1000; max-height: 600px; overflow-y: auto;">
    <li class="list-group-item text-left list-group-item-success" v-for="(suggestion, index) in suggestions" :key="index" @click="selectSuggestion(suggestion)">
     {{ suggestion }}
    </li>
   </ul>
   

   <!-- Dropdown for Filter Selection -->
    <!-- <div class="dropdown me-2">
      <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
      </button>
      <ul class="dropdown-menu">
        <li>
          <a class="dropdown-item" href="#">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" v-model="filters.translation" id="translationCheckbox" @change="updateSuggestions" />
              <label class="form-check-label" for="translationCheckbox">Translation</label>
            </div>
          </a>
        </li>
        <li>
          <a class="dropdown-item" href="#">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" v-model="filters.tafseer" id="tafseerCheckbox" @change="updateSuggestions" />
              <label class="form-check-label" for="tafseerCheckbox">Tafseer</label>
            </div>
          </a>
        </li>
        <li>
          <a class="dropdown-item" href="#">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" v-model="filters.transliteration" id="transliterationCheckbox" @change="updateSuggestions" />
              <label class="form-check-label" for="transliterationCheckbox">Transliteration</label>
            </div>
          </a>
        </li>
      </ul>
    </div> -->
    
    

   <!-- Voice input button -->
   <button type="button" class="btn" @click="isListening ? stopVoiceRecognition() : startVoiceRecognition()" style="background:linear-gradient(144deg,#AF40FF, #5B42F3 50%,#00DDEB); ">
    <i class=" bi text-white pr-1" :class="isListening ? 'bi-stop-fill' : 'bi-mic-fill'" aria-hidden="true"></i><span style="color:white"><b>Voice Search</b></span>
   </button>
   <!--
    <button class="btn btn-info text-white" @click="searchWord"><i class="bi bi-search h4 text-white"></i></button>
    -->
  </div>
 </div>
 
 
 <!-- show a message when recording starts -->
 <h3 v-if="isListening" class="pt-1"><b class="pt-1">Listening...</b></h3>

 <!-- Offcanvas for Search Results -->
<div class="offcanvas offcanvas-end custom-offcanvas" tabindex="-1" id="offcanvasResults">
  <div class="offcanvas-header">
   <h5 class="offcanvas-title">Search Results</h5>
   <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
  </div>
    <div ref="targetTafseerElement" class="offcanvas-body text-left">
    <!-- Display Results -->
    

    <div v-if="filteredResults.length && !loading">
      <div>
        <h5>Total Number of Surat: {{ totalSurahs }}</h5>
        <h5>Total Number of Ayat: {{ totalAyahs }}</h5>
      </div>
      <hr>
      <div v-for="result in filteredResults" :key="result.id" class="result-item">
        <div :id="'result-' + result.id">        
          

          <div class="text-left pb-2">
            <h4>{{ result.ayah.surah_id }} : {{ result.ayah.ayah_id }}</h4>
          </div>
          <div class="container pt-3 pb-3">
            <button type="button" class=" w-100 btn btn-light"><b>Go To Ayah</b></button>
          </div>
          <h3 class="text-right">{{ result.ayah.ayah_text }}</h3>
          <div>
            <h5 ><b>Translation: </b></h5>
            <span v-html="highlightSearch(expanded ? result.translation : result.translation)"></span>
        
          </div>
          <div>
            <h5 class="pt-2"><b>Tafseer: </b></h5>
            <span v-html="highlightSearch(expanded ? result.originalTafseer : result.originalTafseer)"></span>
            
          </div>
          <div>
            <h5 class="pt-2"><b>Transliteration: </b></h5>
            <span v-html="highlightSearch(expanded ? result.transliteration : result.transliteration)"></span>
          </div>
          
        </div>
        <div class=" pt-3">
          <button @click="shareOnWhatsApp(result)" type="button" class="container btn btn-success w-100">
            <i @click="fastForwardSpeech"
           style="cursor: pointer;"
           aria-label="Fast forward audio"
           class="bi bi-fast-forward-circle-fill ml-2 mr-2 h3 custom-icon-play"></i>Share on WhatsApp
          </button>
        </div>
           
        <hr />
      </div>
    </div>
   <div v-else-if="!loading" class="text-center">
    <h5>No search results found.</h5>
   </div>
   <div v-if="loading" class="text-center">
    <h5>Loading...</h5>
   </div>
  </div>
 </div>

</div>
</template>

<script>
import jsPDF from 'jspdf';
import html2canvas from 'html2canvas';
import {
 debounce
} from 'lodash';
import axios from 'axios';


export default {
 mounted() {
  const dropdown = document.querySelector('.dropdown');
  if (this.information?.ayah?.id) {
      this.fetchTafseer(this.information.ayah.id);
  }
  if (dropdown) {
   dropdown.addEventListener('click', this.toggleDropdown);
  }
 },
 props:{
   translation: {
   type: String,
   required: true,
  },
  information: {
   type: Object,
   required: true
  },
  targetTranslationRef: {
   type: String,
   default: 'targetTranslationElement',
  },
 },

 data() {
  return {
   data: [],
   loading: false,
   searchTerm: '',
   suggestions: [],
   tafseer: "",
   filteredResults: [],
   expanded: false,
   showMoreLink: true,
   information: {
      translation: '', // Ensure translation is initialized
      ayah_id: null,   // Ensure ayah_id is initialized
    },
   filters: {
    translation: true, // Default filter for translation enabled
    tafseer: false, // Default filter for tafseer disabled
    transliteration: false // Default filter for transliteration disabled
   },
   isListening: false,
   recognition: null,
   timer: null,
  };
 },
  computed: {
    totalSurahs() {
      const surahIds = this.filteredResults.map(result => result.ayah.surah_id);
      return new Set(surahIds).size; // Calculate unique surahs
    },
    totalAyahs() {
      return this.filteredResults.length; // Calculate total ayahs
    }
  },
 
 watch: {
  // Watch for changes to `information.ayah.id`
  "information.ayah.id": {
   immediate: true, // Run on initial component mount as well
   handler(newId, oldId) {
    if (newId !== oldId) {
     this.fetchTafseer(newId); // Refetch tafseer when ayah ID changes
    }
   },
  },
 },
 props: {
  result: Object,
  information: Object,
 },
 methods: {
  shareOnWhatsApp(result) {
    // Construct the message you want to share
    const message = `Ayah: ${result.ayah.surah_id}:${result.ayah.ayah_id}\n\n` + `${result.ayah.ayah_text}\n\n` + `Translation: ${result.translation}\n\n` + `Tafseer: ${result.originalTafseer}\n\n` + `Transliteration: ${result.transliteration}`;
    // Encode the message to be used in a URL
    const whatsappUrl = `https://wa.me/?text=${encodeURIComponent(message)}`;
    // Open WhatsApp with the pre-populated message
    window.open(whatsappUrl, '_blank');
  },
  totalSurahs() {
    const surahIds = this.filteredResults.map(result => result.ayah.surah_id);
    return new Set(surahIds).size; // Unique surahs
  },
  totalAyahs() {
    return this.filteredResults.length; // Total ayahs
  },
  async fetchTafseer(ayahId) {
    try {
      const tafseerResponse = await axios.get(
          `/tafseer/${ayahId}/fetch`
      );
      this.tafseer = tafseerResponse.data; // Assign the fetched data to the local state
    } catch (error) {
      console.error("Error fetching tafseer:", error);
    }
  },
  toggleExpand() {
    this.expanded = !this.expanded; // Toggle the expanded state
  },
  highlightSearch(text) {
    // Your logic for highlighting search terms
    return text; // Return the text with highlights
  },
  // Trigger suggestions based on input length
  onInput() {
   if (this.searchTerm.length > 3) {
    this.fetchSuggestions();
   } else {
    this.suggestions = [];
    this.filteredResults = [];
   }
  },
  fetchSuggestions() {
   const params = {
    query: this.searchTerm,
    filters: this.filters,
   };

   this.loading = true; // Start loading

   axios.get('/search-translations', {
     params
    })
    .then((response) => {
     this.suggestions = response.data.suggestions || []; // Fallback to empty array
     this.filteredResults = response.data.results || []; // Fallback to empty array
    })
    .catch((error) => {
     console.error('Error fetching suggestions:', error);
     this.suggestions = []; // Reset suggestions on error
     this.filteredResults = []; // Reset filtered results on error
    })
    .finally(() => {
     this.loading = false; // Stop loading
    });
  },

  // Select a suggestion and fetch its results
  selectSuggestion(suggestion) {
   this.searchTerm = suggestion;
   this.suggestions = [];
   this.fetchResults(suggestion); // Fetch results based on selected suggestion
   this.showOffcanvas();
  },

  // Select a search result
  selectResult(result) {
   this.searchTerm = result.content; // Update searchTerm with the result content
   this.filteredResults = []; // Clear search results
   this.suggestions = []; // Clear suggestions
   this.saveSearch(result.content); // Save the search term
  },

  // Submit search and save term if not already present
  submitSearch() {
   const query = this.searchTerm.toLowerCase();
   if (query && !this.recentSearches.includes(query)) {
    this.recentSearches.push(query);
    localStorage.setItem('recentSearches', JSON.stringify(this.recentSearches));
   }
   this.filterSuggestions(); // Trigger suggestions based on updated searchTerm
  },

  // Start voice recognition
  startVoiceRecognition() {
   this.isListening = true;
   const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;

   if (!SpeechRecognition) {
    alert('Speech Recognition is not supported in this browser. Please use Google Chrome or a compatible browser.');
    this.isListening = false;
    return;
   }

   this.recognition = new SpeechRecognition();
   this.recognition.lang = 'en-US';
   this.recognition.continuous = false;

   this.recognition.onresult = (event) => {
    const transcript = event.results[0][0].transcript;
    this.searchTerm = transcript;
    this.isListening = false;
    this.fetchSuggestions(); // Fetch suggestions immediately after speech input
   };

   this.recognition.onend = () => {
    this.isListening = false;
   };

   this.recognition.onerror = (event) => {
    console.error('Speech recognition error:', event.error);
    this.isListening = false;
   };

   this.recognition.start();
  },

  // Stop voice recognition
  stopVoiceRecognition() {
   if (this.recognition) {
    this.recognition.stop();
    this.isListening = false;
    this.searchWord();
    this.showOffcanvas();
   }
  },

  fetchResults(suggestion) {
   const params = {
    query: suggestion,
    filters: this.filters,
   };

   // Use POST if you prefer sending larger payloads, otherwise keep GET
   axios.get('/search-translations', {
     params
    })
    .then((response) => {
     this.filteredResults = response.data.results || []; // Ensure fallback
     console.log('Filtered results:', this.filteredResults); // Log filtered results for debugging
    })
    .catch((error) => {
     console.error('Error fetching results:', error);
     this.filteredResults = []; // Reset filtered results on error
    });
  },

  // Highlight the search term in the text
  highlightSearch(text) {
   const searchTerm = this.searchTerm.trim();
   if (!searchTerm) return text;

   const regex = new RegExp(`(${searchTerm})`, 'gi');
   return text.replace(regex, '<strong style="background-color: #3EB489;">$1</strong>');
  },

  // Download a PDF of the result
  downloadPDF(result) {
   const element = document.getElementById(`result-${result.id}`);
   element.style.color = 'black'; // Ensure visibility

   html2canvas(element).then((canvas) => {
    const imgData = canvas.toDataURL('image/png');
    const pdf = new jsPDF({
     orientation: 'portrait',
     unit: 'mm',
     format: 'a4',
    });
    const fileName = `Surah_${result.ayah.surah_id}_Ayah_${result.ayah.ayah_id}.pdf`;

    pdf.addImage(imgData, 'PNG', 10, 10, 190, 0); // Adjust the dimensions as needed
    pdf.save(fileName);
    element.style.color = ''; // Reset to original or preferred color
   }).catch((error) => {
    console.error('Error capturing the element:', error);
   });
  },

  searchWord() {
   this.loading = true;

   // Get the active filters
   const activeFilters = {
    translation: this.filters.translation,
    tafseer: this.filters.tafseer,
    transliteration: this.filters.transliteration,
   };

   // Prepare the request payload
   const payload = {
    query: this.searchTerm, // Use 'query' instead of 'searchTerm'
    filters: activeFilters
   };

   // Fetch results from the backend based on selected filters and searchTerm
   axios.post('/search-translations', payload)
    .then(response => {
     this.filteredResults = response.data; // Adjust to match your response structure
     this.loading = false;
     this.showOffcanvas(); 
    })
    .catch(error => {
     console.error('Error fetching search results:', error);
     this.loading = false;
    });
  },

  // Show the offcanvas component for results
  showOffcanvas() {
    // Use Bootstrap JS to programmatically open the offcanvas
    let offcanvasElement = document.getElementById('offcanvasResults');
    let offcanvas = new bootstrap.Offcanvas(offcanvasElement);
    offcanvas.show();
  },

  // Debounced search to limit the number of fetch calls
  debouncedSearch: _.debounce(function () {
  clearTimeout(this.timer); // Clear previous timer
  this.loading = true; // Show loading indicator
        this.timer = setTimeout(this.fetchSuggestions, 4000);

   this.fetchSuggestions();
  }, )
 },
 


};
</script>

<style scoped>
.custom-link{
  color: white;
  font-size: bold;
}
@media (max-width: 576px) {
 .mobile-only {
  display: block;
  display: flex;
  width: 100%;
 }

 .custom-offcanvas {
  background-color: #10584f;
  color: white;
 }

 .hide-on-mobile {
  display: none;
 }
}

.search-container {
 position: relative;
 width: 100%;
}

.search-input {
 width: 100%;
 border-radius: 4px;
}

.suggestions {
 position: absolute;
 top: 100%;
 left: 0;
 width: 80%;
 z-index: 1000;
 max-height: 600px;
 overflow-y: auto;
 border-top-left-radius: 0;
 border-top-right-radius: 0;
 border-bottom-left-radius: 4px;
 border-bottom-right-radius: 4px;
 box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.highlight {
 background-color: #3EB489;
 font-weight: bold;
}

.recent-searches {
 position: relative;
 width: 300px;
 /* Adjust the width as needed */
}

.search-input {
 width: 100%;
 padding: 10px;
 font-size: 16px;
 border: 1px solid #ccc;
 border-radius: 4px;
}

.suggestions {
 position: absolute;
 background: white;
 border: 1px solid #ccc;
 border-radius: 4px;
 margin-top: 5px;
 width: 100%;
 max-height: 150px;
 /* Limit dropdown height */
 overflow-y: auto;
 /* Enable scrolling */
 z-index: 10;
 /* Ensure dropdown appears above other content */
}

.suggestions li {
 padding: 8px;
 cursor: pointer;
}

.suggestions li:hover {
 background-color: #f0f0f0;
 /* Highlight on hover */
}

.btn-primary {
 background-color: #00BFA6 !important;
 border-radius: 10px;
}

.btn-primary:focus {
 box-shadow: none;
}

.text {
 font-size: 13px;
}

.flex-row {
 border: 1px solid #F2F2F4;
 border-radius: 10px;
 margin: 0 1px 0;
}

.form-control {
 box-sizing: border-box;
 padding: 10px;
 font-size: 1rem;
}

.dropdown-menu {
 background-color: white;
 border: 1px solid lightgrey;
 border-radius: 5px;
}

.list-group-item {
 border: none;
}

.alert-container {
 position: absolute;
 /* Position it absolutely */
 top: 10px;
 /* Adjust this value to control vertical position */
 left: 10px;
 /* Adjust this value to control horizontal position */
 z-index: 1000;
 /* Ensure it appears above other content */
}

.alert {
 margin-bottom: 10px;
 /* Add some spacing between alerts */
}

.custom-offcanvas {
 background-color: #10584f;
 color: white;
 width: 40%;
}

.custom-offcanvas .result-item {
 margin-bottom: 15px;
}

.pdf-content {
 /* Adjust text properties */
 font-family: Arial, sans-serif;
 /* Set a specific font */
 font-size: 14px;
 /* Set a base font size */
 line-height: 1.5;
 /* Set line height for readability */
 color: black;
 /* Set default text color to black */
 padding: 10px;
 /* Add padding for better layout */
}

.translation-text {
 color: black;
 /* Ensure translation text is visible */
 margin-top: 10px;
 /* Add spacing above the translation */
}

.suggestions-list {
 list-style-type: none;
 padding: 0;
 margin: 0;
}

.suggestions-list li {
 padding: 10px;
 cursor: pointer;
}

.suggestions-list li:hover {
 background-color: #f1f1f1;
}
</style>