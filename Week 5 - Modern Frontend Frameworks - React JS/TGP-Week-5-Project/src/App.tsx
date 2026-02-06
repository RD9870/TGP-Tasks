import { Route, Routes } from "react-router-dom";
import Login from "./pages/login";
import Products from "./pages/productsPage";
import Dashboard from "./pages/dashboard";
import OutOfStock from "./pages/out-of-stock";

function App() {
  return (
    <>
      {/* define the app routes */}
      <Routes>
        <Route path="" element={<Login />} />
        <Route path="login" element={<Login />} />
        <Route path="dashboard" element={<Dashboard />}>
          <Route index element={<Products />} />
          <Route path="products" element={<Products />} />
          <Route path="OutOfStock" element={<OutOfStock />} />
        </Route>
      </Routes>
    </>
  );
}

export default App;
