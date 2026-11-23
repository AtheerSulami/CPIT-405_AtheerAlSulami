/* Student: Atheer AlSulami | ID: 2307149 | CPIT 405 Lab 10 */
/* AJAX: GET JSON from the PHP controller, then update the DOM. */
document.addEventListener('DOMContentLoaded', () => {
  const refreshButton = document.getElementById('refresh');
  const status = document.getElementById('ajax-status');
  const list = document.getElementById('live-tasks');
  if (!refreshButton || !status || !list) return;

  refreshButton.addEventListener('click', async () => {
    refreshButton.disabled = true;
    status.textContent = 'Loading...';
    try {
      const response = await fetch('api.php', { cache: 'no-store' });
      const data = await response.json();
      if (!response.ok || !data.ok) throw new Error('Database unavailable');
      list.replaceChildren();
      data.tasks.forEach((task) => {
        const item = document.createElement('li');
        item.textContent = task.title + ' — ' + task.status.replace('_', ' ');
        list.appendChild(item);
      });
      status.textContent = data.tasks.length + ' task(s) loaded via AJAX';
    } catch (error) {
      list.replaceChildren();
      status.textContent = 'Could not fetch tasks. Check MariaDB.';
    } finally {
      refreshButton.disabled = false;
    }
  });
});
