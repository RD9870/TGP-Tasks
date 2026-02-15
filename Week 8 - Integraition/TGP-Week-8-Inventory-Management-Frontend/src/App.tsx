import React from "react";
import Header from "./components/layout/Header";
import Sidebar from "./components/layout/Sidebar";
import Login from "./pages/login";
import { Route, Routes, useLocation } from "react-router-dom";
import ReceiptForm from "./pages/receiot";
import ProfitDetails from "./pages/profitDetails";
import UsersPage from "./pages/users";
import CategoriesPage from "./pages/Categories";
import ProductsPage from "./pages/Products";
import Dashboard from "./pages/dashboard";

function AppContent() {
  // location
  const location = useLocation();
  // mobile menue controller variable
  const [isMobileMenuOpen, setIsMobileMenuOpen] = React.useState(false);
  // user info
  const userRole = localStorage.getItem("user_type");
  const userName = localStorage.getItem("user_name");
  // app ui
  return (
    <div className="flex">
      {/* side menue bar */}
      <Sidebar
        currentPath={location.pathname}
        isMobileMenuOpen={isMobileMenuOpen}
        setIsMobileMenuOpen={setIsMobileMenuOpen}
      />
      <main className="md:ml-60 flex-1 w-full">
        {/* header witht the username and  */}
        <Header
          userRole={userRole!}
          userName={userName!}
          onMenuClick={() => setIsMobileMenuOpen(true)}
        />
        {/* website routes (aka the routs that will have the side bar and header) */}
        <Routes>
          <Route path="dashboard" element={<Dashboard />} />
          <Route path="profitDetails" element={<ProfitDetails />} />
          <Route path="users" element={<UsersPage />} />
          <Route path="Categories" element={<CategoriesPage />} />
          <Route path="Products" element={<ProductsPage />} />
          {/* if the user types in something other than the above show a 404 page */}
          <Route
            path="*"
            element={
              <div className="p-10 text-white">404 - Page Not Found</div>
            }
          />
        </Routes>
      </main>
    </div>
  );
}

function App() {
  return (
    // app routes without the side bar and header
    <Routes>
      <Route path="" element={<Login />} />
      <Route path="login" element={<Login />} />
      <Route path="receipt" element={<ReceiptForm />} />
      {/* the * means that if the route doesn't match any of the above routes to take it here */}
      <Route path="*" element={<AppContent />} />
    </Routes>
  );
}

export default App;
