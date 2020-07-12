import React, { useState } from "react";
import { Container } from "react-bootstrap";
import { useParams } from "react-router-dom";
import useDataApi from "../utils/data-api";
import { useForm } from "react-hook-form";
import ErrorMessage from "./ErrorMessage";
import Success from "./Success";

export default function EditOrganisation() {
    let { id } = useParams();

    const [isSaving, setIsSaving] = useState(false);
    const [isSaveError, setIsSaveError] = useState(false);
    const [isSuccess, setIsSuccess] = useState(false);

    const [{ data, isLoading, isError }, doFetch] = useDataApi(
        `/organisations/${id}`,
        {
            records: []
        }
    );

    const org = data.records;
    const onSubmit = data => {
        const url = id ? `/organisations/${id}` : `/organisations`;
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
            {isLoading || isSaving ? (
                <div>Busy ...</div>
            ) : (
                <form onSubmit={handleSubmit(onSubmit)}>
                    <div className="form-group">
                        <label>Name</label>
                        <input
                            type="text"
                            name="name"
                            defaultValue={org.name}
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
                        <label>Description</label>
                        <input
                            type="text"
                            name="description"
                            defaultValue={org.description}
                            ref={register({
                                required: true,
                                minLength: 8
                            })}
                            className="form-control"
                        />
                        {errors.description && "Description is required"}
                    </div>
                    <input type="submit" className="btn btn-primary" />
                </form>
            )}
        </Container>
    );
}
