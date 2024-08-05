import React from "react";
import { BrowserRouter, Routes, Route } from "react-router-dom";
import { ShowHotels } from "./components/ShowHotels";
import { CreateHotels } from "./components/CreateHotels";
import { EditHotels } from "./components/EditHotels";

function App() {
  return (
    <BrowserRouter>
      <div className="App">
        <Routes>
          <Route path="/" element={<ShowHotels />} />
          <Route path="/create" element={<CreateHotels />} />
          <Route path="/edit/:id" element={<EditHotels />} />
        </Routes>
      </div>
    </BrowserRouter>
  );
}

export default App;
