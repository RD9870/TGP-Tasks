import { useState } from "react";
import Btn from "../components/btn";
import TextField from "../components/textField";
import ax from "../api/api";
import { useNavigate } from "react-router-dom";
import toast from "react-hot-toast";

function Login() {
  const [isClicked, setIsClicked] = useState<boolean>(false);
  const navigate = useNavigate();
  const [userInput, setUserInput] = useState({
    username: "",
    password: "",
  });

  const LogUserIn = async (e: React.FormEvent) => {
    e.preventDefault();
    try {
      setIsClicked(true);
      const auth = await ax.post("/auth/login", userInput, {
        headers: { "Content-Type": "application/json" },
      });
      const { accessToken, refreshToken } = auth.data;
      localStorage.setItem("token", accessToken);
      localStorage.setItem("refreshToken", refreshToken);
      navigate("/dashboard/products");
      toast(`Welcome in ${auth.data.firstName}`, {
        icon: "👋",
      });
    } catch (err) {
      console.error(err);
      toast.error("Something went wrong. Please try again.");
    } finally {
      setIsClicked(false);
    }
  };

  const onUserTyping = (e: React.ChangeEvent<HTMLInputElement>) => {
    setUserInput({
      ...userInput,
      [e.target.name]: e.target.value,
    });
  };

  return (
    <div className="w-full h-screen relative flex items-center justify-center p-4 flex-col gap-6">
      <img
        src="../assets/nasr-city-shopping-cairo_16by9.webp"
        className="blur-xs absolute inset-0 w-full h-full object-cover"
      />
      <h1 className="z-10 m-4 uppercase text-white font-bold text-4xl">
        One Glance System
      </h1>
      <div className="relative z-20 bg-[url(../assets/nasr-city-shopping-cairo_16by9.webp)] bg-cover bg-center flex flex-col md:flex-row rounded-lg shadow-xl overflow-hidden w-full max-w-md md:max-w-4xl">
        <div className="w-full md:w-1/2 text-white text-center flex justify-center flex-col py-8 px-8 bg-black/20">
          <h1 className="font-bold text-2xl">welcome Back</h1>
          <h4 className="font-light">good to see you again</h4>
        </div>

        <form className="w-full md:w-1/2 flex flex-col gap-4 p-8 bg-opacity-20">
          <TextField
            value={userInput.username}
            textColor="white"
            label="username"
            icon="../assets/e-mail.svg"
            type="text"
            id="usernameTextField"
            name="username"
            onChange={onUserTyping}
          />

          <TextField
            value={userInput.password}
            textColor="white"
            label="password"
            icon="../assets/pass.svg"
            type="password"
            id="passwordTextField"
            name="password"
            onChange={onUserTyping}
          />

          <Btn
            label="login"
            color="bg-btn-orange"
            whenClicked={LogUserIn}
            disable={isClicked}
          />
        </form>
      </div>
    </div>
  );
}

export default Login;
