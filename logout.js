const SUPABASE_URL = "https://eppxrgnnkrrlzoihgvhq.supabase.co";
const SUPABASE_ANON_KEY =
  "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVwcHhyZ25ua3JybHpvaWhndmhxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NDIxNDYzMzgsImV4cCI6MjA1NzcyMjMzOH0.FeMdaGRSvUJRT1O6uZT_-IbsuuPKvCO956sU568geCk";
const supabase = window.supabase.createClient(SUPABASE_URL, SUPABASE_ANON_KEY, {
  auth: { persistSession: true },
});

document.addEventListener("DOMContentLoaded", function () {
  const logoutBtn = document.getElementById("logout-btn");

  if (logoutBtn) {
    logoutBtn.addEventListener("click", async function () {
      await supabase.auth.signOut();
      alert("Logged out successfully!");
      window.location.href = "login.html";
    });
  }
});
