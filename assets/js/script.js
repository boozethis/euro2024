document.addEventListener("DOMContentLoaded", function() {
    const fixturesList = document.getElementById("fixtures-list");
    const countdownTimer = document.getElementById("countdown-timer");

    const bootstrapUrl = "https://fantasy.premierleague.com/api/bootstrap-static/";
    const fixturesUrl = "https://fantasy.premierleague.com/api/fixtures/";

    // Fetch current gameweek data
    fetch(bootstrapUrl)
        .then(response => response.json())
        .then(data => {
            const events = data.events;
            const teams = data.teams.reduce((map, team) => {
                map[team.id] = team.name;
                return map;
            }, {});

            let currentGameweekId = events.find(event => event.is_current)?.id;

            // Handle season transition: if no current gameweek, find the first gameweek of the new season
            if (!currentGameweekId || currentGameweekId === 38) {
                currentGameweekId = events.find(event => event.is_next)?.id || 1;
            }

            console.log("Current Gameweek ID:", currentGameweekId); // Debugging: Log the current gameweek ID

            if (currentGameweekId) {
                // Fetch fixtures for the current gameweek
                fetch(fixturesUrl)
                    .then(response => response.json())
                    .then(fixtures => {
                        const currentGameweekFixtures = fixtures.filter(fixture => fixture.event === currentGameweekId);

                        // Verify the season year to ensure we have the correct season fixtures
                        const currentYear = new Date().getFullYear();
                        const firstFixtureYear = new Date(currentGameweekFixtures[0]?.kickoff_time).getFullYear();

                        if (firstFixtureYear === currentYear) {
                            // Sort fixtures by kickoff time to get the earliest one
                            currentGameweekFixtures.sort((a, b) => new Date(a.kickoff_time) - new Date(b.kickoff_time));

                            if (currentGameweekFixtures.length > 0) {
                                const firstFixture = currentGameweekFixtures[0];
                                const kickoffTime = new Date(firstFixture.kickoff_time);

                                // Debugging: Log the kickoff time
                                console.log("First fixture kickoff time:", kickoffTime);

                                // Set countdown timer
                                setCountdown(kickoffTime);

                                // Display fixtures
                                fixturesList.innerHTML = '';
                                currentGameweekFixtures.forEach(fixture => {
                                    const fixtureItem = document.createElement("div");
                                    const homeTeam = teams[fixture.team_h];
                                    const awayTeam = teams[fixture.team_a];
                                    if (homeTeam && awayTeam) {
                                        const fixtureKickoffTime = new Date(fixture.kickoff_time).toLocaleString();
                                        fixtureItem.textContent = `${homeTeam} vs ${awayTeam} (${fixtureKickoffTime})`;
                                        fixturesList.appendChild(fixtureItem);
                                    }
                                });
                            } else {
                                fixturesList.innerHTML = '<p>No fixtures found for the current gameweek. Please disable your adblocker or visit the <a href="https://fantasy.premierleague.com/fixtures" target="_blank">official fixtures page</a>.</p>';
                            }
                        } else {
                            fixturesList.innerHTML = '<p>The fixtures data appears to be from the previous season. Please check back later for the updated fixtures.</p>';
                        }
                    })
                    .catch(error => {
                        console.error("Error fetching fixtures:", error);
                        fixturesList.innerHTML = '<p>Unable to load fixtures. Please disable your adblocker or visit the <a href="https://fantasy.premierleague.com/fixtures" target="_blank">official fixtures page</a>.</p>';
                    });
            } else {
                fixturesList.innerHTML = '<p>No current gameweek found. Please disable your adblocker or visit the <a href="https://fantasy.premierleague.com/fixtures" target="_blank">official fixtures page</a>.</p>';
            }
        })
        .catch(error => {
            console.error("Error fetching bootstrap data:", error);
            fixturesList.innerHTML = '<p>Unable to load fixtures. Please disable your adblocker or visit the <a href="https://fantasy.premierleague.com/fixtures" target="_blank">official fixtures page</a>.</p>';
        });

    function setCountdown(kickoffTime) {
        function updateCountdown() {
            const now = new Date().getTime();
            const distance = kickoffTime - now;

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            if (distance >= 0) {
                countdownTimer.textContent = `${days}d ${hours}h ${minutes}m ${seconds}s`;
            } else {
                countdownTimer.textContent = "EXPIRED";
            }
        }

        updateCountdown(); // Initial call to set the countdown immediately
        setInterval(updateCountdown, 1000); // Update every second
    }

    // FAQ toggle
    const faqItems = document.querySelectorAll(".faq-item h3");
    faqItems.forEach(item => {
        item.addEventListener("click", () => {
            const answer = item.nextElementSibling;
            if (answer.style.display === "block") {
                answer.style.display = "none";
            } else {
                document.querySelectorAll(".faq-content").forEach(content => {
                    content.style.display = "none";
                });
                answer.style.display = "block";
            }
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
