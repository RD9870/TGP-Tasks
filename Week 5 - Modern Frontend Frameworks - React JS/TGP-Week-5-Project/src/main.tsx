import { StrictMode } from "react";
import { createRoot } from "react-dom/client";
import "./index.css";
import App from "./App.tsx";
import { BrowserRouter } from "react-router-dom";
import { Toaster } from "react-hot-toast";

createRoot(document.getElementById("root")!).render(
  // wrap the app in StrictMode to help identify potential problems
  <StrictMode>
    {/* wrap the app in  BrowserRouter to enable routing functionality */}
    <BrowserRouter>
      {/* wrap the app in Toaster to show user feedback messages */}
      <Toaster position="top-center" reverseOrder={false} />
      <App />
    </BrowserRouter>
  </StrictMode>,
);
