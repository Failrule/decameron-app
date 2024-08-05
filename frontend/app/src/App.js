import React from "react";
import { BrowserRouter, Routes, Route } from "react-router-dom";
import { ShowHotels } from "./components/ShowHotels";
import { CreateHotels } from "./components/CreateHotels";
import { EditHotels } from "./components/EditHotels";
import { ShowRoomTypesAcc } from "./components/ShowRoomTypesAcc";
import { CreateTypeAcc } from "./components/CreateTypeAcc";

function App() {
  return (
    <BrowserRouter>
      <div className="App">
        <Routes>
          <Route path="/" element={<ShowHotels />} />
          <Route path="/create" element={<CreateHotels />} />
          <Route path="/edit/:id" element={<EditHotels />} />
          <Route path="/typesacc/:id" element={<ShowRoomTypesAcc />} />
          <Route path="/createtipeacc/:id" element={<CreateTypeAcc />} />
        </Routes>
      </div>
    </BrowserRouter>
  );
}

export default App;
