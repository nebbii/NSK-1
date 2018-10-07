<?php

/*
 * Nexxus Stock Keeping (online voorraad beheer software)
 * Copyright (C) 2018 Copiatek Scan & Computer Solution BV
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see licenses.
 *
 * Copiatek � info@copiatek.nl � Postbus 547 2501 CM Den Haag
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Pickup;
use AppBundle\Entity\PurchaseOrder;
use AppBundle\Entity\Supplier;
use AppBundle\Entity\PickupImageFile;
use AppBundle\Entity\PickupAgreementFile;
use AppBundle\Entity\ProductOrderRelation;
use AppBundle\Form\PickupForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\FormError;

class PickupController extends Controller
{
    /**
     * @Route("/pickup", name="pickup")
     * @Route("/ophaaldienst", name="ophaaldienst")
     * @Method({"GET", "POST"})
     */
    public function pickupAction(Request $request)
    {
        $success = null;

        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AppBundle:Pickup');

        $pickup = new Pickup();
        $order = new PurchaseOrder();
        $order->setOrderDate(new \DateTime());
        $supplier = new Supplier();

        $em->persist($pickup);
        $em->persist($order);
        $em->persist($supplier);

        $order->setSupplier($supplier);
        $pickup->setOrder($order);

        $form = $this->createForm(PickupForm::class, $pickup);

        $form->handleRequest($request);

        if ($request->isMethod('POST') && $form->isSubmitted()) // && $this->captchaVerify($request->request->get('g-recaptcha-response')))
        {
            if ($form->isValid())
            {
                #region Form data processing

                // Create full order

                $location = $em->getReference("AppBundle:Location", $form->get('locationId')->getData());
                $pickup->getOrder()->setLocation($location);

                $pickup->getOrder()->setSupplier($em->getRepository('AppBundle:Supplier')->checkExists($pickup->getOrder()->getSupplier()));

                $pickup->getOrder()->setStatus($em->getRepository('AppBundle:OrderStatus')->findOrCreate($form->get('orderStatusName')->getData()));

                // Images
                $imageNames = $this->splitImagesNames($form->get('imagesNames')->getData());
                foreach ($imageNames as $imageName)
                {
                    $file = new PickupImageFile();
                    $file->setUniqueServerFilename(substr($imageName, 0, 13));
                    $file->setOriginalClientFilename(substr($imageName, 13));
                    $em->persist($file);
                    $pickup->addImage($file);
                }

                // Agreement
                $agreementName = $form->get('agreementName')->getData();
                if ($agreementName)
                {
                    $file = new PickupAgreementFile();
                    $file->setUniqueServerFilename(substr($agreementName, 0, 13));
                    $file->setOriginalClientFilename(substr($agreementName, 13));
                    $em->persist($file);
                    $pickup->setAgreement($file);
                }

                // Products
                $productTypes = array("Computer", "Server", "Phone", "Printer", "Monitor");
                foreach ($productTypes as $productType)
                {
                    $quantity = $form->get('q'.$productType)->getData();
                    if ($quantity)
                    {
                        $product = $em->getRepository('AppBundle:Product')->generateProductFromQuantity($quantity, $productType);
                        $product->setLocation($location);

                        $r = new ProductOrderRelation();
                        $r->setOrder($pickup->getOrder());
                        $r->setProduct($product);
                        $em->persist($r);
                        $pickup->getOrder()->addProductRelation($r);
                    }
                }

                #endregion

                $em->flush();

                $success = true;
            }
            else
            {
                $success = false;
            }
        }

        return $this->render('AppBundle:Pickup:pickup.html.twig', array(
                'form' => $form->createView(),
                'success' => $success,
            ));
    }

    private function captchaVerify($recaptcha)
    {
        $url = "https://www.google.com/recaptcha/api/siteverify";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array(
            "secret"=>"6LdyzXMUAAAAAHSGkIAZE1QirknxwARCQbgAfHm4","response"=>$recaptcha));
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response);

        return $data->success;
    }

    private function splitImagesNames($imageNamesString)
    {
        $imageNames = explode(",", $imageNamesString);
        $imageNames = array_filter($imageNames); // remove empty
        $imageNames = array_unique($imageNames);
        return $imageNames;
    }
}
