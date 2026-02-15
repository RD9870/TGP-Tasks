import { StrictMode } from "react";
import { createRoot } from "react-dom/client";
import "./index.css";
import App from "./App.tsx";
import { BrowserRouter } from "react-router-dom";
import { Toaster } from "react-hot-toast";

createRoot(document.getElementById("root")!).render(
  // enable strick mode to catch potential errors
  <StrictMode>
    {/* router prouser to allow user to browse the app */}
    <BrowserRouter>
      {/* toaster sittings */}
      <Toaster
        position="top-center"
        containerStyle={{
          zIndex: 99999,
        }}
        toastOptions={{
          style: {
            background: "#1e293b",
            color: "#fff",
            border: "1px solid #334155",
          },
        }}
        reverseOrder={false}
      />
      {/* the app caomponent */}
      <App />
    </BrowserRouter>
  </StrictMode>,
);
