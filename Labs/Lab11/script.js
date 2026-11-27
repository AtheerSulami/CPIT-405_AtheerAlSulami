// Student: Atheer AlSulami | Student ID: 2307149 | CPIT 405 Lab 11
// Assessment 3: Use AJAX to request the PHP JSON and display it in the Console.

const button = document.querySelector('#fetch-json');
const status = document.querySelector('#status');
const output = document.querySelector('#json-output');

button.addEventListener('click', async () => {
  button.disabled = true;
  status.textContent = 'Requesting JSON from PHP...';

  try {
    const response = await fetch('grades.php', { cache: 'no-store' });
    if (!response.ok) {
      throw new Error('HTTP ' + response.status);
    }

    const grades = await response.json();
    console.log('Lab 11 AJAX JSON result:', grades);

    output.textContent = JSON.stringify(grades, null, 2);
    status.textContent = 'Success! JSON received and printed to the Console.';
  } catch (error) {
    console.error('Lab 11 AJAX request failed:', error);
    output.textContent = 'Could not load the JSON response.';
    status.textContent = 'Request failed. Start the PHP server and try again.';
  } finally {
    button.disabled = false;
  }
});
