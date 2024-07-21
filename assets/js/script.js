document.addEventListener("DOMContentLoaded", function() {
  const countdownElement = document.getElementById("countdown-timer");
  const fixturesTitleElement = document.getElementById("fixtures-title");
  const fixturesListElement = document.getElementById("fixtures-list");

  const now = new Date();

  fetch('assets/js/fixtures.json')
    .then(response => response.json())
    .then(data => {
      const currentGameweek = data.gameweeks.find(gw => {
        const startDate = new Date(gw.start_date);
        const endDate = new Date(gw.end_date);
        return now >= startDate && now <= endDate;
      });

      if (currentGameweek) {
        fixturesTitleElement.textContent = `Gameweek ${currentGameweek.gameweek} Fixtures`;
        fixturesListElement.innerHTML = currentGameweek.fixtures.map(fixture => `
          <div>${fixture.home} vs ${fixture.away}</div>
        `).join("");
      } else {
        fixturesListElement.innerHTML = "Unable to load fixtures. Please check back later.";
      }

      // Assuming the deadline for the current gameweek is the end date of the gameweek
      const deadline = new Date(currentGameweek.end_date).getTime();
      updateCountdown(deadline);
    })
    .catch(error => {
      console.error("Error fetching fixtures:", error);
      fixturesListElement.innerHTML = "Unable to load fixtures. Please check back later.";
    });

  function updateCountdown(deadline) {
    const now = new Date().getTime();
    const distance = deadline - now;

    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

    countdownElement.innerHTML = `
      ${days}d ${hours}h ${minutes}m ${seconds}s
    `;

    if (distance < 0) {
      countdownElement.innerHTML = "EXPIRED";
    } else {
      setTimeout(() => updateCountdown(deadline), 1000);
    }
  }
});
