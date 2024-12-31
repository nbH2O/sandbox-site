import './bootstrap';

// Function to calculate and update time remaining
window.timeUntil = function (el, from, to) {
      // Create Date objects in UTC by appending 'Z' to indicate UTC
      const targetTime = new Date(to + "Z").getTime(); // Target time in milliseconds (UTC)
      const startTime = new Date(from + "Z").getTime(); // From time in milliseconds (UTC)

      const interval = setInterval(() => {
        const now = new Date().getTime(); // Current time in milliseconds (local timezone)
        
        let timeRemaining;

        // Check if the "from" time is in the future
        if (now < startTime) {
          // If "from" is in the future, calculate time remaining until "from"
          timeRemaining = startTime - now;
          el.textContent = getTimeString(timeRemaining);
        } else if (now < targetTime) {
          // If "from" has passed, calculate time remaining until "to"
          timeRemaining = targetTime - now;
          el.textContent = getTimeString(timeRemaining);
        } else {
          // If both "from" and "to" have passed, stop the timer
          clearInterval(interval);
          el.textContent = "Time's up!";
        }
      }, 1000); // Update every second
    }

    // Function to format the remaining time as a string (largest timescale)
    function getTimeString(timeRemaining) {
      const days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
      const hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      const minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
      const seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

      if (days > 0) {
        return `${days} day${days > 1 ? 's' : ''}`;
      } else if (hours > 0) {
        return `${hours} hour${hours > 1 ? 's' : ''}`;
      } else if (minutes > 0) {
        return `${minutes} minute${minutes > 1 ? 's' : ''}`;
      } else {
        return `${seconds} second${seconds > 1 ? 's' : ''}`;
      }
    }
