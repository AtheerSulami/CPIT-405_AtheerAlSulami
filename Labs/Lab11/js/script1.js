// Student: Atheer AlSulami | Student ID: 2307149 | CPIT 405 - Lab 11
// Assessment: Ajax GET for PHP associative-array JSON and XML; log JSON in Console.
// Homework: Ajax GET/POST controller -> model -> MariaDB -> JSON -> update DOM.

'use strict';

const app = document.querySelector('#app');
const csrfToken = app.dataset.csrf;
const jsonButton = document.querySelector('#load-json');
const xmlButton = document.querySelector('#load-xml');
const responseOutput = document.querySelector('#response-output');
const responseStatus = document.querySelector('#response-status');
const formatLabel = document.querySelector('#format-label');
const gradesBody = document.querySelector('#grades-body');
const databaseStatus = document.querySelector('#database-status');
const addForm = document.querySelector('#add-grade');
const refreshButton = document.querySelector('#refresh-grades');

function setDatabaseStatus(message, type) {
  databaseStatus.textContent = message;
  databaseStatus.className = 'notice' + (type ? ' ' + type : '');
}

// Every displayed record uses textContent/input.value (never unsanitized innerHTML).
function element(tag, text, className) {
  const node = document.createElement(tag);
  if (text !== undefined) node.textContent = text;
  if (className) node.className = className;
  return node;
}

function renderGrades(grades) {
  gradesBody.replaceChildren();
  if (!grades.length) {
    const tr = element('tr');
    const td = element('td', 'No records yet. Add your first student.', 'empty');
    td.colSpan = 4;
    tr.appendChild(td);
    gradesBody.appendChild(tr);
    return;
  }
  for (const grade of grades) {
    const row = element('tr');
    const idCell = element('td', String(grade.id));
    const nameCell = element('td');
    const nameInput = document.createElement('input');
    nameInput.className = 'name-input';
    nameInput.type = 'text';
    nameInput.maxLength = 100;
    nameInput.value = grade.name;
    nameInput.setAttribute('aria-label', 'Student ' + grade.id + ' name');
    nameCell.appendChild(nameInput);

    const totalCell = element('td');
    const totalInput = document.createElement('input');
    totalInput.type = 'number';
    totalInput.min = '0';
    totalInput.max = '5';
    totalInput.step = '0.5';
    totalInput.value = String(grade.total);
    totalInput.setAttribute('aria-label', 'Student ' + grade.id + ' total');
    totalCell.appendChild(totalInput);

    const actionCell = element('td');
    const actions = element('div', undefined, 'row-actions');
    const save = element('button', 'Save', 'outline small');
    save.type = 'button';
    save.addEventListener('click', () => {
      if (!nameInput.value.trim() || !totalInput.checkValidity()) {
        setDatabaseStatus('Enter a valid name and a total from 0 to 5.', 'error');
        return;
      }
      changeGrade('update', {
        id: grade.id,
        name: nameInput.value.trim(),
        total: totalInput.value
      });
    });
    const remove = element('button', 'Delete', 'danger small');
    remove.type = 'button';
    remove.addEventListener('click', () => {
      changeGrade('delete', { id: grade.id });
    });
    actions.append(save, remove);
    actionCell.appendChild(actions);
    row.append(idCell, nameCell, totalCell, actionCell);
    gradesBody.appendChild(row);
  }
}

async function readJSONResponse(url, init) {
  const response = await fetch(url, init);
  const data = await response.json();
  if (!response.ok || data.success === false) {
    throw new Error(data.message || 'The server request failed.');
  }
  return data;
}

async function loadGrades() {
  setDatabaseStatus('Requesting records from MariaDB...');
  refreshButton.disabled = true;
  try {
    const data = await readJSONResponse('grades.php', { cache: 'no-store' });
    renderGrades(data.grades);
    setDatabaseStatus(data.grades.length + ' record(s) loaded successfully via AJAX.', 'success');
  } catch (error) {
    renderGrades([]);
    setDatabaseStatus('Request failed: ' + error.message, 'error');
  } finally {
    refreshButton.disabled = false;
  }
}

async function changeGrade(action, payload) {
  setDatabaseStatus('Sending ' + action + ' request via AJAX...');
  const params = new URLSearchParams();
  params.set('action', action);
  params.set('csrf_token', csrfToken);
  for (const [key, value] of Object.entries(payload)) {
    params.set(key, String(value));
  }
  try {
    const data = await readJSONResponse('grades.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8' },
      body: params
    });
    renderGrades(data.grades);
    setDatabaseStatus(data.message + ' Table updated without page reload.', 'success');
    if (action === 'create') addForm.reset();
  } catch (error) {
    setDatabaseStatus('Request failed: ' + error.message, 'error');
  }
}

jsonButton.addEventListener('click', async () => {
  jsonButton.disabled = true;
  responseStatus.textContent = 'Requesting JSON from PHP...';
  try {
    const response = await fetch('assessment.php', { cache: 'no-store' });
    if (!response.ok) throw new Error('HTTP ' + response.status);
    const grades = await response.json();

    // Explicit assessment requirement: display JSON via Developer Tools Console.
    console.log('CPIT 405 Lab 11 — PHP JSON response:', grades);
    responseOutput.textContent = JSON.stringify(grades, null, 2);
    formatLabel.textContent = 'application/json';
    responseStatus.textContent = 'Success! Check DevTools → Console for the PHP JSON response.';
  } catch (error) {
    responseStatus.textContent = 'AJAX JSON request failed: ' + error.message;
    responseOutput.textContent = 'Could not load data.';
  } finally {
    jsonButton.disabled = false;
  }
});

xmlButton.addEventListener('click', async () => {
  xmlButton.disabled = true;
  responseStatus.textContent = 'Requesting XML from PHP...';
  try {
    const response = await fetch('xml.php', { cache: 'no-store' });
    if (!response.ok) throw new Error('HTTP ' + response.status);
    const xmlText = await response.text();
    const xml = new DOMParser().parseFromString(xmlText, 'application/xml');
    if (xml.querySelector('parsererror')) throw new Error('Invalid XML document.');
    const students = [...xml.querySelectorAll('student')].map((student) => ({
      name: student.querySelector('name')?.textContent || '',
      total: student.querySelector('total')?.textContent || ''
    }));
    console.log('CPIT 405 Lab 11 — PHP XML parsed:', students);
    responseOutput.textContent = JSON.stringify(students, null, 2);
    formatLabel.textContent = 'application/xml (parsed)';
    responseStatus.textContent = 'Success! XML was parsed using the DOMParser API.';
  } catch (error) {
    responseStatus.textContent = 'AJAX XML request failed: ' + error.message;
    responseOutput.textContent = 'Could not load XML.';
  } finally {
    xmlButton.disabled = false;
  }
});

addForm.addEventListener('submit', (event) => {
  event.preventDefault();
  const form = new FormData(addForm);
  changeGrade('create', {
    name: String(form.get('name')).trim(),
    total: String(form.get('total'))
  });
});
refreshButton.addEventListener('click', loadGrades);
loadGrades();
