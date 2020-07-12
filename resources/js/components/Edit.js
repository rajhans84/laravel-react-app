import React, { useState } from "react";
import { Container } from "react-bootstrap";
import { useParams } from "react-router-dom";
import useDataApi from "../utils/data-api";
import { useForm } from "react-hook-form";
import ErrorMessage from "./ErrorMessage";
import Success from "./Success";

export default function EditForm() {
    let { id } = useParams();

    const [isSaving, setIsSaving] = useState(false);
    const [isSaveError, setIsSaveError] = useState(false);
    const [isSuccess, setIsSuccess] = useState(false);

    const [{ data, isLoading, isError }, doFetch] = useDataApi(`/users/${id}`, {
        records: []
    });

    const user = data.records;
    const onSubmit = data => {
        const url = id ? `/users/${id}` : `/users`;
        axios
            .post(url, data)
            .then(res => {
                console.log(res);
                console.log(res.data);
                setIsSuccess(true);
                setIsSaveError(false);
                setIsSaving(false);
            })
            .catch(error => {
                console.log(error);
                setIsSaveError(true);
                setIsSuccess(false);
                setIsSaving(false);
            });
    };

    const { register, errors, handleSubmit } = useForm();

    return (
        <Container fluid>
            {(isError || isSaveError) && <ErrorMessage />}
            {isSuccess && <Success />}
            {isLoading ? (
                <div>Loading ...</div>
            ) : (
                <form onSubmit={handleSubmit(onSubmit)}>
                    <div className="form-group">
                        <label>Name</label>
                        <input
                            type="text"
                            name="name"
                            defaultValue={user.name}
                            ref={register({
                                required: true,
                                maxLength: 255,
                                message: "Name is required"
                            })}
                            className="form-control"
                        />
                        {errors.name && "Name is required"}
                    </div>
                    <div className="form-group">
                        <label>Email</label>
                        <input
                            type="text"
                            name="email"
                            defaultValue={user.email}
                            ref={register({
                                required: true,
                                pattern: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
                                message: "A Valid email is required"
                            })}
                            className="form-control"
                        />
                        {errors.email && "A Valid email is required"}
                    </div>
                    <div className="form-group">
                        <label>Password</label>
                        <input
                            type="password"
                            name="password"
                            ref={register({
                                required: true,
                                minLength: 8
                            })}
                            className="form-control"
                        />
                        {errors.password && "Password is required"}
                    </div>
                    <div className="form-group">
                        <label>Select User type</label>
                        <select
                            name="is_admin"
                            defaultValue={user.is_admin}
                            ref={register({ required: true })}
                            className="custom-select"
                        >
                            <option value="1">Admin</option>
                            <option value="0">Employee</option>
                        </select>
                    </div>
                    <input type="submit" className="btn btn-primary" />
                </form>
            )}
        </Container>
    );
}
