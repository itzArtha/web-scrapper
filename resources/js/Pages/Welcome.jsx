import { Head } from '@inertiajs/react';
import GuestLayout from '@/Layouts/GuestLayout';
import {useState} from "react";
import { Dropdown } from 'primereact/dropdown';
import TextInput from '@/Components/TextInput';
import PrimaryButton from "@/Components/PrimaryButton.jsx";
import { useForm } from '@inertiajs/react'
export default function Welcome({status, scraps}) {
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
                    <div className="p-inputgroup flex">
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
                {status &&
                <div className={"mt-4"}>
                    <p className={"text-center"}>Download hasil scrap <a href={status + "/scrap/download"} target={'_blank'} className={"text-blue-500"}>disini</a></p>
                </div>}
                <div className={"mt-4"}>
                    <p className={"text-center"}>Riwayat scrapping</p>
                    <div className='mt-4'>
                        <div className='grid grid-cols-4 gap-2'>
                            {scraps.map((scrap, index) => (    
                                <a href={scrap.uuid + '/scrap/download'} class="flex items-center">
                                    <img class="w-10 h-10 rounded-full mr-4" src="https://w7.pngwing.com/pngs/422/204/png-transparent-microsoft-excel-microsoft-office-365-spreadsheet-microsoft-text-logo-microsoft-office-thumbnail.png" alt="Avatar of Jonathan Reinink" />
                                    <div class="text-sm">
                                        <p class="text-gray-900 text-sm leading-none">{`products ${index + 1}`}.xlsx</p>
                                        <p class="text-gray-600 text-xs">{new Date(scrap.created_at).toLocaleDateString()}</p>
                                    </div>
                                </a>
                            ))}
                        </div>
                    </div>
                </div>
            </GuestLayout>
        </>
    );
}
