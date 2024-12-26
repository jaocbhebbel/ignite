function getExam() {
  fetch('exams/csci-2500-spring-2024-3.pdf')
    .then(response => {
      if (!response.ok) {
        throw new Error("Failed to fetch the PDF");
      }
      return response.blob();
    })
    .then(blob => {
      const blobUrl = URL.createObjectURL(blob); // Create a Blob URL
      const iframe = document.getElementById("pdfViewer");
      iframe.src = blobUrl; // Set the Blob URL as the source of the iframe
    })
    .catch(error => {
      console.error("Error fetching or rendering the PDF:", error);
    });
  }

function pingAPI() {
  fetch('../api.php')
    .then(response => {
      if (!response.ok) {
        throw new Error("Failed to ping api.php");
      }
      return response.json();
    })
    .then(response => {
      const tag = document.getElementById('message');
      tag.innerHTML = `<pre>${JSON.stringify(response, null, 2)}</pre>`;
    })
    .catch(error => {
      const tag = document.getElementById('message');
      tag.innerHTML = `Error: ${error.message}`;
    });
}

function getComporg() {
  console.log('entering comporg');
  payload = {
    sql: { courses: {major: 'csci'} }, // gets all cs exams
    returnExamFiles: false
  }
  const url = `../api.php?payload=${encodeURIComponent(JSON.stringify(payload))}`;
  
  div = document.getElementById('output');

  fetch(url)
        .then(response => {
            if (!response.ok) {
                console.log("response is not ok");
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {

            if(!data || data == null) {
              console.log('data is null');
            } else {
              error = {'it doesnt': 'want to render'};
              div.innerHTML = `<pre>${JSON.stringify(data, null, 2)}</pre>` || `${error}`;
            }
        })
        .catch(error => {
            console.error('Error in GET request:', error);
        });
}

getComporg();