import { Route, Routes } from "react-router-dom";
import Login from "./pages/login";
import Products from "./pages/productsPage";
import Dashboard from "./pages/dashboard";
import OutOfStock from "./pages/out-of-stock";

function App() {
  return (
    <>
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

// <Routes>
//       {/* Index route */}
//       <Route path="" element={<Login />} />

//       <Route path="login" element={<Login />} />

//       {/* Simple route Example */}
//       <Route path="dashboard" element={<Dashboard />}>

//         {/* Nested routes */}
//         <Route index element={<DashboardIndex />} />

//         <Route path="users" element={<Users />}>
//           <Route index element={<UsersList />} />
//           <Route path="add" element={<UserForm />} />
//           <Route path=":id" element={<UserForm />} />
//         </Route>

//       </Route>
//     </Routes>
