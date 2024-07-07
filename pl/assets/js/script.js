document.addEventListener("DOMContentLoaded", function() {
    const fixturesList = document.getElementById("fixtures-list");
    const corsProxy = "https://api.allorigins.win/raw?url="; // Public CORS proxy

    fetch(`${corsProxy}https://fantasy.premierleague.com/api/bootstrap-static/`)
        .then(response => {
            console.log("Fetched bootstrap-static data", response);
            return response.json();
        })
        .then(data => {
            console.log("Parsed bootstrap-static data", data);
            let nextGameweekId;
            for (const event of data.events) {
                if (event.is_next) {
                    nextGameweekId = event.id;
                    break;
                }
            }
            console.log("Next gameweek ID", nextGameweekId);
            if (nextGameweekId) {
                fetch(`${corsProxy}https://fantasy.premierleague.com/api/fixtures/?event=${nextGameweekId}`)
                    .then(response => {
                        console.log("Fetched fixtures data", response);
                        return response.json();
                    })
                    .then(fixtures => {
                        console.log("Parsed fixtures data", fixtures);
                        fixtures.forEach(fixture => {
                            const fixtureItem = document.createElement("div");
                            const homeTeam = data.teams.find(team => team.id === fixture.team_h);
                            const awayTeam = data.teams.find(team => team.id === fixture.team_a);
                            if (homeTeam && awayTeam) {
                                const kickoffTime = new Date(fixture.kickoff_time).toLocaleString();
                                fixtureItem.textContent = `${homeTeam.name} vs ${awayTeam.name} (${kickoffTime})`;
                                fixturesList.appendChild(fixtureItem);
                            } else {
                                console.warn("Home or away team not found", fixture);
                            }
                        });
                    })
                    .catch(error => {
                        console.error("Error fetching fixtures:", error);
                        fixturesList.textContent = "Unable to load fixtures.";
                    });
            } else {
                fixturesList.textContent = "No upcoming fixtures found.";
            }
        })
        .catch(error => {
            console.error("Error fetching bootstrap data:", error);
            fixturesList.textContent = "Unable to load fixtures.";
        });

    // Countdown timer
    const countdownTimer = document.getElementById("countdown-timer");
    const countdownDate = new Date("August 16, 2024 20:00:00").getTime();

    function updateCountdown() {
        const now = new Date().getTime();
        const distance = countdownDate - now;

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        countdownTimer.textContent = `${days}d ${hours}h ${minutes}m ${seconds}s`;

        if (distance < 0) {
            countdownTimer.textContent = "EXPIRED";
        }
    }

    setInterval(updateCountdown, 1000);

    // FAQ toggle
    const faqItems = document.querySelectorAll(".faq-item h3");
    faqItems.forEach(item => {
        item.addEventListener("click", () => {
            const answer = item.nextElementSibling;
            answer.style.display = answer.style.display === "block" ? "none" : "block";
        });
    });

    // Active nav item
    const navItems = document.querySelectorAll(".nav-item");
    navItems.forEach(item => {
        item.addEventListener("click", () => {
            navItems.forEach(nav => nav.classList.remove("nav-item-active"));
            item.classList.add("nav-item-active");
        });
    });
});
