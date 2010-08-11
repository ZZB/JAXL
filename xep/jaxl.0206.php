<?php
/* Jaxl (Jabber XMPP Library)
 *
 * Copyright (c) 2009-2010, Abhinav Singh <me@abhinavsingh.com>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Abhinav Singh nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRIC
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 */

	/*
	 * XEP-0206: XMPP over BOSH
	 * Uses XEP-0124 to wrap XMPP stanza's inside <body/> wrapper
	*/
	class JAXL0206 {
		
		public static function init() {}
		
		public static function startStream($host, $port) {
			global $jaxl;
			
			$xml = "";
			$xml .= "<body";
			$xml .= " content='".$jaxl->bosh['content']."'";
			$xml .= " hold='".$jaxl->bosh['hold']."'";
			$xml .= " xmlns='".$jaxl->bosh['xmlns']."'";
			$xml .= " wait='".$jaxl->bosh['wait']."'";
			$xml .= " rid='".$jaxl->bosh['rid']."'";
			$xml .= " version='".$jaxl->bosh['version']."'";
			$xml .= " polling='".$jaxl->bosh['polling']."'";
			$xml .= " secure='".$jaxl->bosh['secure']."'";
			$xml .= " xmlns:xmpp='".$jaxl->bosh['xmlnsxmpp']."'";
			
			$xml .= " to='".$host."'";
			$xml .= " route='xmpp:".$host.":".$port."'";
			$xml .= " xmpp:version='".$jaxl->bosh['xmppversion']."'/>";
			
			XMPPSend::xml($xml);
		}
		
		public static function endStream() {
			global $jaxl;
			
			$xml = "";
			$xml .= "<body";
			$xml .= " rid='".++$jaxl->bosh['rid']."'";
			$xml .= " sid='".$jaxl->bosh['sid']."'";
			$xml .= " type='terminate'";
			$xml .= " xmlns='".$jaxl->bosh['xmlns']."'>";
			$xml .= "<presence type='unavailable' xmlns='jabber:client'/>";
			$xml .= "</body>";
			
			XMPPSend::xml($xml);
		}
		
		public static function restartStream() {
			global $jaxl;
			
			$xml = "";
			$xml .= "<body";
			$xml .= " rid='".++$jaxl->bosh['rid']."'";
			$xml .= " sid='".$jaxl->bosh['sid']."'";
			$xml .= " xmlns='".$jaxl->bosh['xmlns']."'";
			
			$xml .= " to='".JAXL_HOST_NAME."'";
			$xml .= " xmpp:restart='true'";
			$xml .= " xmlns:xmpp='".$jaxl->bosh['xmlnsxmpp']."'/>";
			
			XMPPSend::xml($xml);
		}
		
		public static function ping() {
			global $jaxl;
			
			$xml = '';
			$xml .= '<body rid="'.++$jaxl->bosh['rid'].'" sid="'.$jaxl->bosh['sid'].'" xmlns="http://jabber.org/protocol/httpbind"/>';
			XMPPSend::xml($xml);
		}
		
	}
	
?>