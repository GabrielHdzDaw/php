function openTab(evt, tabName) {
  // Declare all variables
  let i, tabcontent, tablinks;

  // Hide all tab content
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
  }

  // Remove active class from all buttons
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
      tablinks[i].classList.remove("active");
  }

  // Show the current tab and mark button as active
  document.getElementById(tabName).style.display = "block";
  evt.currentTarget.classList.add("active");
}

// Initialize tabs when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
  // Add click event to all tab buttons
  const tabButtons = document.querySelectorAll('.tablinks');
  tabButtons.forEach(button => {
      button.addEventListener('click', function(e) {
          openTab(e, this.dataset.tab);
      });
  });
  
  // Open first tab by default
  if (tabButtons.length > 0) {
    tabButtons[0].click();
  }
  
  // // Optional: Check if hash exists in URL to open specific tab
  // if (window.location.hash) {
  //     const tabFromHash = document.querySelector(`.tablinks[data-tab="${window.location.hash.substring(1)}"]`);
  //     if (tabFromHash) {
  //         tabFromHash.click();
  //     }
  // }
});