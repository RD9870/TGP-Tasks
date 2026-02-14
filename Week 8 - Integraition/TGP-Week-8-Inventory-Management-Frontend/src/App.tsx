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
  const location = useLocation();
  const [isMobileMenuOpen, setIsMobileMenuOpen] = React.useState(false);
  const userRole = localStorage.getItem("user_type");
  const userName = localStorage.getItem("user_name");

  return (
    <div className="flex">
      <Sidebar
        currentPath={location.pathname}
        isMobileMenuOpen={isMobileMenuOpen}
        setIsMobileMenuOpen={setIsMobileMenuOpen}
      />
      <main className="md:ml-60 flex-1 w-full">
        <Header
          userRole={userRole!}
          userName={userName!}
          onMenuClick={() => setIsMobileMenuOpen(true)}
        />
        <Routes>
          <Route path="dashboard" element={<Dashboard />} />
          <Route path="profitDetails" element={<ProfitDetails />} />
          <Route path="users" element={<UsersPage />} />
          <Route path="Categories" element={<CategoriesPage />} />
          <Route path="Products" element={<ProductsPage />} />
        </Routes>
      </main>
    </div>
  );
}

function App() {
  return (
    <Routes>
      <Route path="" element={<Login />} />
      <Route path="login" element={<Login />} />

      <Route path="receipt" element={<ReceiptForm />} />
      <Route path="*" element={<AppContent />} />
    </Routes>
  );
}

export default App;
