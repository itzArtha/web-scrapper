import { Head } from '@inertiajs/react';
import GuestLayout from '@/Layouts/GuestLayout';
import {useState} from "react";
import { Dropdown } from 'primereact/dropdown';
import TextInput from '@/Components/TextInput';
import PrimaryButton from "@/Components/PrimaryButton.jsx";

export default function Welcome() {
    const [selected, setSelected] = useState(null);
    const commerces = [
        { name: 'Tokopedia', code: 'TP' },
        { name: 'Shopee', code: 'SP' }
    ];

    return (
        <>
            <Head title="Welcome" />
            <GuestLayout>
                <div className={"grid grid-cols-3 gap-2"}>
                    <div className={"col-span-1"}>
                        <Dropdown value={selected} onChange={(e) => setSelected(e.value)}
                                  options={commerces} optionLabel="name"
                                  placeholder="Pilih eCommerce" className="w-full md:w-14rem" />
                    </div>
                    <div className="p-inputgroup flex-1 col-span-2">
                        <TextInput
                            id="url"
                            type="url"
                            name="url"
                            value={""}
                            className="mt-1 block w-full"
                            placeholder={"URL"}
                            autoComplete="username"
                            isFocused={true}
                            onChange={(e) => console.log('ok')}
                        />
                        <PrimaryButton className="ms-2" disabled={false}>
                            Scrap
                        </PrimaryButton>
                    </div>
                </div>
            </GuestLayout>
        </>
    );
}
