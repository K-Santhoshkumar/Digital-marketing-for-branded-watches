const container = document.getElementById("container");
const registerBtn = document.getElementById("register");
const loginBtn = document.getElementById("login");

registerBtn.addEventListener("click", () => {
  container.classList.add("active");
});

loginBtn.addEventListener("click", () => {
  container.classList.remove("active");
});

// Initialize Supabase
const SUPABASE_URL = "https://eppxrgnnkrrlzoihgvhq.supabase.co";
const SUPABASE_ANON_KEY =
  "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVwcHhyZ25ua3JybHpvaWhndmhxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NDIxNDYzMzgsImV4cCI6MjA1NzcyMjMzOH0.FeMdaGRSvUJRT1O6uZT_-IbsuuPKvCO956sU568geCk";

const supabase = window.supabase.createClient(SUPABASE_URL, SUPABASE_ANON_KEY, {
  auth: { persistSession: true },
});

document.addEventListener("DOMContentLoaded", async function () {
  console.log("Checking authentication...");
  await checkAuth();
});
// **Sign In with Email & Password**
async function signin(event) {
  event.preventDefault();
  const email = document.getElementById("login-email").value.trim();
  const password = document.getElementById("login-password").value.trim();

  if (!email || !password) {
    alert("Please enter email and password.");
    return;
  }

  const { data, error } = await supabase.auth.signInWithPassword({
    email,
    password,
  });

  if (error) {
    alert("Error: " + error.message);
    console.error("Login error:", error);
  } else {
    alert("Login successful!");
    fetch("session.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ email }),
    });

    window.location.href = "home.html";
  }
}

// **Sign Up with Email & Password**
async function signup(event) {
  event.preventDefault();
  const name = document.getElementById("username").value.trim();
  const email = document.getElementById("signup-email").value.trim();
  const password = document.getElementById("signup-password").value.trim();

  if (!email || !password || !name) {
    alert("Please fill in all fields.");
    return;
  }

  const { data, error } = await supabase.auth.signUp({
    email,
    password,
    options: { data: { name } },
  });

  if (error) {
    alert("Error: " + error.message);
    console.error("Sign-up error:", error);
  } else {
    alert("Sign-up successful! Check your email for confirmation.");
  }
}
/* 
// **Sign In with Google**
async function signInWithGoogle() {
  const { error } = await supabase.auth.signInWithOAuth({
    provider: "google",
  });

  if (error) {
    console.error("Google sign-in error:", error.message);
    alert("Google Sign-In failed: " + error.message);
  } else {
    window.location.href = "home.html";
  }
}

// **Sign In with GitHub**
async function signInWithGithub() {
  const { error } = await supabase.auth.signInWithOAuth({
    provider: "github",
  });

  if (error) {
    console.error("GitHub sign-in error:", error.message);
    alert("GitHub Sign-In failed: " + error.message);
  } else {
    window.location.href = "home.html";
  }
}
 */
// **Check if User is Authenticated**
async function checkAuth() {
  const { data } = await supabase.auth.getSession();

  if (data.session) {
    console.log("User session found:", data.session.user);
    if (!window.location.pathname.includes("home.html")) {
      window.location.href = "home.html";
    }
  } else {
    console.log("No valid session found. Redirecting to login...");
    if (!window.location.pathname.includes("login.html")) {
      window.location.href = "login.html";
    }
  }
}

// **Logout Function**
async function logout() {
  await supabase.auth.signOut();
  alert("Logged out successfully!");
  window.location.href = "login.html";
}
