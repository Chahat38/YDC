/**
 * YDC KUST — registrations ko Google Sheet mein save karne ka script.
 * Steps: Google Sheet banao > Extensions > Apps Script > yeh code paste karo >
 * Deploy > New deployment > Web app > "Anyone" > Deploy > URL copy karo >
 * assets/js/config.js mein formEndpoint mein paste karo.
 */
const NOTIFY = "ydc@kust.edu.pk";   // nayi registration par email yahan aayegi ("" = band)

function doPost(e) {
  const d = JSON.parse(e.postData.contents);
  const tab = d.form === "contact" ? "Contact" : "Registrations";
  const ss = SpreadsheetApp.getActiveSpreadsheet();
  const sh = ss.getSheetByName(tab) || ss.insertSheet(tab);
  const cols = ["submitted_at","reference","program","subject","name","email","phone","roll","department","semester","message","page"];
  if (sh.getLastRow() === 0) sh.appendRow(cols);
  sh.appendRow(cols.map(c => d[c] || ""));
  if (NOTIFY) {
    MailApp.sendEmail(NOTIFY, "[YDC] " + (d.program || d.subject || "New submission") + " - " + d.name,
      cols.map(c => c + ": " + (d[c] || "")).join("\n"));
  }
  return ContentService.createTextOutput("ok");
}
