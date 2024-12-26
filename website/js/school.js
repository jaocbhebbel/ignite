document.addEventListener("DOMContentLoaded", () => {
    const urlParams = new URLSearchParams(window.location.search);
    const school = urlParams.get("school"); // Get the "school" parameter from the URL

    if (!school) {
        document.body.innerHTML = `<p>Error: No school specified in the URL.</p>`;
        return;
    }

    // Update the header dynamically based on the school
    const schoolTitles = {
        engineering: "School of Engineering",
        business: "School of Business",
        arts: "School of Arts",
        science: "School of Science"
    };

    const schoolDescriptions = {
        engineering: "Explore our courses designed to inspire future engineers.",
        business: "Discover programs designed for future leaders in the business world.",
        arts: "Dive into creative programs that shape the world of tomorrow.",
        science: "Embark on a journey of discovery with our exceptional science programs."
    };

    document.getElementById("school-title").innerText = schoolTitles[school] || "School";
    document.getElementById("school-description").innerText = schoolDescriptions[school] || "Welcome to the school.";

    // Fetch course data from PHP using GET
    const coursesContainer = document.getElementById("courses-container");

    fetch(`../backend/php/api.php?school=${school}`, { method: 'GET' })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json(); // Parse JSON response
        })
        .then(data => {
            if (data.error) {
                coursesContainer.innerHTML = `<p>Error: ${data.error}</p>`;
                return;
            }

            if (data.length === 0) {
                coursesContainer.innerHTML = `<p>No courses found for this school.</p>`;
                return;
            }

            // Create a table to display the fetched data
            const table = document.createElement("table");
            table.classList.add("courses-table");

            // Add table header
            table.innerHTML = `
                <thead>
                    <tr>
                        <th>Course Code</th>
                        <th>Course Name</th>
                        <th>Semester</th>
                        <th>Year</th>
                        <th>Exam Name</th>
                    </tr>
                </thead>
            `;

            // Add table rows
            const tbody = document.createElement("tbody");
            data.forEach(course => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${course.course_code}</td>
                    <td>${course.course_name}</td>
                    <td>${course.semester}</td>
                    <td>${course.school_year}</td>
                    <td>${course.exam_name}</td>
                `;
                tbody.appendChild(row);
            });

            table.appendChild(tbody);
            coursesContainer.appendChild(table);
        })
        .catch(error => {
            coursesContainer.innerHTML = `<p>Error loading courses: ${error.message}</p>`;
        });
});
