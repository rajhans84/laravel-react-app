import React, { useState, useEffect } from "react";
import { useParams } from "react-router-dom";

import Delete from "./Delete";

export default function DeleteOrg() {
    let { id } = useParams();
    return <Delete url={`/organisations/${id}`} />;
}
