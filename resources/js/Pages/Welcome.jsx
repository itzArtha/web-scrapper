import { Head } from '@inertiajs/react';
import GuestLayout from '@/Layouts/GuestLayout';
import {useState} from "react";
import { Dropdown } from 'primereact/dropdown';
import TextInput from '@/Components/TextInput';
import PrimaryButton from "@/Components/PrimaryButton.jsx";
import { useForm } from '@inertiajs/react'
export default function Welcome() {
    const { data, setData, post, processing, errors } = useForm({
        code: '',
        url: ''
    })

    const commerces = [
        { name: 'Tokopedia', code: 'TP' },
        { name: 'Shopee', code: 'SP' }
    ];

    const handleSubmit = (e) => {
        e.preventDefault()
        post(route('website.scrap'))
    }

    return (
        <>
            <Head title="Welcome" />
            <GuestLayout>
                <div className={"grid grid-cols-3 gap-2"}>
                    <div className={"col-span-1"}>
                        <Dropdown value={data.code} onChange={(e) => setData("code", e.value)}
                                  options={commerces} optionLabel="name"
                                  placeholder="Pilih eCommerce" className="w-full md:w-14rem" />
                    </div>
                    <div className="p-inputgroup flex-1 col-span-2">
                        <TextInput
                            id="url"
                            type="url"
                            name="url"
                            value={data.url}
                            className="mt-1 block w-full"
                            placeholder={"URL"}
                            autoComplete="username"
                            isFocused={true}
                            onChange={(e) => setData("url", e.target.value)}
                        />
                        <PrimaryButton className="ms-2" disabled={processing} onClick={handleSubmit}>
                            Scrap
                        </PrimaryButton>
                    </div>
                </div>
                <div className={"mt-4"}>
                    <p className={"text-center"}>Download hasil scrap <a href="#" className={"text-blue-500"}>disini</a></p>
                </div>
            </GuestLayout>
        </>
    );
}
